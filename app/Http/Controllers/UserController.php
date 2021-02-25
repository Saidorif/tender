<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;
use App\Permission;
use App\User;
use JWTAuth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $pers = [];
        $permissions = Permission::where(['role_id' => $user->role->id])->with(['controller', 'action'])->get();
        foreach($permissions as $k => $permission){
            $pers[$k]['action'] = $permission->action->code;
            $pers[$k]['subject'] = $permission->controller->name;
        }
        $pers = array_unique($pers, SORT_REGULAR);
        $pers = array_values($pers);
        $result['permissions'] = $pers;
        $result['user'] = User::where(['id' => $user->id])->with('role')->withCount(['cars','applications','contracts'])->first();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|min:3',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $client = User::where('company_name','LIKE','%'.$inputs['name'].'%')
                ->orWhere('inn','LIKE','%'.$inputs['name'].'%')
                ->orWhere('name','LIKE','%'.$inputs['name'].'%')
                ->orWhere('surname','LIKE','%'.$inputs['name'].'%')
                ->orWhere('middlename','LIKE','%'.$inputs['name'].'%')
                ->get();

        return response()->json(['success' => true, 'result' => $client]);
    }

    public function changePasword(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'password'    => 'required|string|min:6',
            'confirm_password'    => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true, 'message' => 'Пароли не совпадают']);
        }

        $user->password = Hash::make($inputs['password']);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Пароль успешно изменен']);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'role_id'     => 'required|integer',
            'phone'       => 'string|nullable',
            'address'     => 'string|nullable',
            'text'        => 'string|nullable',
            'category_id' => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        //Upload file and image
        if ($request->image != $user->image) {
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time()."image.".$ex;
            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$name);
            $image = $img_path.$user->image;
            if (file_exists($image)) {
                @unlink($image);
            }
        }
        else{
            $name = $user->image;
        }
        $inputs['image'] = $name;
        unset($inputs['password']);
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function checkuser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inn' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inn = $request->input('inn');
        $user = User::where(['inn' => $inn])->first();
        $info = [];
        if($user && $user->role_id == 9){
            $info['name'] = $user->name;
            $info['company_name'] = $user->company_name ;
            return response()->json(['success' => true,'result'=>$info]);
        }
        return response()->json(['error' => true,'message' => 'No result']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'middlename'    => 'required|string',
            'surname'       => 'required|string',
            'region_id'     => 'required|integer',
            'area_id'       => 'required|integer',
            'city'          => 'required|min:5',
            'bank_number'   => 'required|min:20',
            'oked'          => 'required|min:5',
            'mfo'           => 'required|min:5',
            'inn'           => 'required|min:9|unique:users,inn',
            'phone'         => 'required|min:12',
            'address'       => 'required|string',
            'trusted_person'=> 'required|string',
            'company_name'  => 'required',
            'license_number'  => 'required',
            'license_date'  => 'required',
            'license_type'  => 'required',
            'password'      => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'email'      => 'required|unique:users,email|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true, 'message' => ['password' =>'Password is invalid']]);
        }
        $inputs['role_id'] = 9;
        $inputs['password'] = Hash::make($request->input('password'));

        $user = User::create($inputs);
        $payloads = ['role' => $user->role_id];
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials, $payloads);
        return response()->json(['success' => true, 'message' => 'Registeration success', 'token' => $token]);
    }

    public function carrier(Request $request)
    {
        $params = $request->all();
        $user = $request->user();
        $builder = User::query()->where(['role_id' => 9]);
        if($user->role->name != 'admin'){
            $builder->where(['region_id' => $user->region_id]);
        }
        if(count($params) > 0){
            if(!empty($params['company_name'])){
                $builder->where('company_name','LIKE','%'.$params['company_name'].'%');
            }
            if(!empty($params['name'])){
                $builder->where('name','LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['inn'])){
                $builder->where(['inn' => $params['inn']]);
            }
            if(!empty($params['region_id'])){
                $builder->where(['region_id' => $params['region_id']]);
            }
            if(!empty($params['area_id'])){
                $builder->where(['area_id' => $params['area_id']]);
            }
            if(!empty($params['surname'])){
                $builder->where('surname','LIKE','%'.$params['surname'].'%');
            }
            if(!empty($params['middlename'])){
                $builder->where('middlename','LIKE','%'.$params['middlename'].'%');
            }
        }
        $result = $builder->with(['region','area'])->orderBy('id','DESC')->paginate(12);

        return response()->json(['success' => true, 'result' => $result]);
    }

    public function carrierEdit(Request $request,$id)
    {
        $user = $request->user();
        if($user->role->name == 'admin'){
            $result = User::where(['role_id' => 9])->with(['region','area'])->find($id);
        }else{
            $result = User::where(['role_id' => 9])->where(['region_id' => $user->region_id])->with(['region','area'])->find($id);
        }
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Перевозчик не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);;
    }

    public function createUser(Request $request)
    {
        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);
        $user = \App\User::create($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function carrierUpdate(Request $request,$id)
    {
        $carrier = User::where(['role_id' => 9])->find($id);
        if(!$carrier){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        $validator = Validator::make($request->all(), [
            'status'  => ['required',Rule::in(['active', 'inactive']),],
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('status');
        $carrier->status = $inputs['status'];
        $carrier->save();

        return response()->json(['success' => true, 'message' => 'Статус успешно изменен']);
    }
}
