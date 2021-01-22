<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;
use App\User;
use App\Role;
use App\UserExperience;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $builder = [];
        $user = $request->user();
        if ($user->role_id == 1) {
            $builder = User::query()->with(['role','position'])->where('role_id','!=',9);
        }else{
            $builder = User::query()
                ->where('role_id', '!=', 1)
                ->where('role_id','!=',9)
                ->where('region_id','=',$user->region_id)
                ->with(['role','position']);
        }
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['name'])){
                $builder->where('name','LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['surname'])){
                $builder->where('surname','LIKE','%'.$params['surname'].'%');
            }
            if(!empty($params['middlename'])){
                $builder->where('middlename','LIKE','%'.$params['middlename'].'%');
            }
            if(!empty($params['position_id'])){
                $builder->where(['position_id' => $params['position_id']]);
            }
            if(!empty($params['region_id'])){
                $builder->where(['region_id' => $params['region_id']]);
            }
            if(!empty($params['area_id'])){
                $builder->where(['area_id' => $params['area_id']]);
            }
            if(!empty($params['role_id'])){
                $builder->where(['role_id' => $params['role_id']]);
            }
        }
        $result = $builder->orderBy('id','DESC')->paginate(12);
        // $result = User::with(['role','position'])->orderBy('id','DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $users = User::where('role_id', '!=', 1)->get();
        return response()->json(['success' => true, 'result' => $users]);
    }

    public function checkemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => 'The email has already been taken']);
        }
        return response()->json(['success' => true, 'message' => 'Электронная почта свободно для использования']);
    }

    public function edit(Request $request,$id)
    {
        $client = $request->user();
        if($client->role->name == 'admin'){
            $user = User::with(['role','position','region','area'])->find($id);
        }else{
            $user = User::where('role_id', '=', $client->role_id)->where(['id' => $id])->first();
        }
        if(!$user){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $role_ids = Role::where('name','!=','admin')->pluck('id');
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string',
            'middlename'         => 'required|string',
            'surname'         => 'required|string',
            'region_id'    => 'required|integer',
            'area_id'      => 'nullable|integer',
            'role_id'      => ['required',Rule::in($role_ids),],
            'position_id'  => 'required|integer',
            'phone'        => 'nullable|min:12',
            'password'     => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'email'      => 'required|unique:users,email|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($user->role->name != 'admin'){
            if($inputs['region_id'] != $user->region_id){
                return response()->json(['error' => true, 'message' => 'Region is not match']);
            }
        }
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true,'message' => 'Пароли не совпадают']);
        }
        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['status'] = 'active';
        //Upload file and image
        if($request->image){
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time()."image.".$ex;

            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['image'] = $img_name;
        }

        $employee = User::create($inputs);

        return response()->json(['success' => true, 'message' => 'Пользователь создан успешно']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $role_ids = Role::where('name','!=','admin')->pluck('id');
        $employee = User::where('role_id', '!=', 1)->find($id);
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'status'           => ['required',Rule::in(['active', 'inactive']),],
            'name'             => 'required|string',
            'middlename'       => 'required|string',
            'surname'          => 'required|string',
            'region_id'        => 'required|integer',
            'area_id'          => 'nullable|integer',
            'role_id'          => ['required',Rule::in($role_ids),],
            'position_id'      => 'required|integer',
            'phone'            => 'nullable|min:12',
            'password'         => 'nullable|min:6',
            'confirm_password' => 'nullable|min:6',
            'email'            => 'required|email|unique:users,email,'.$employee->id,
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($user->role->name != 'admin'){
            if($inputs['region_id'] != $user->region_id){
                return response()->json(['error' => true, 'message' => 'Region is not match']);
            }
        }
        if($request->has('password') && $request->has('confirm_password')){
            if($inputs['password'] != '' || strlen($inputs['password']) >= 6){
                if($inputs['password'] !== $inputs['confirm_password']){
                    return response()->json(['error' => true,'message' => 'Пароли не совпадают']);
                }
                $inputs['password'] = Hash::make($inputs['password']);
            }else{
                unset($inputs['password']);
            }
        }else{
            unset($inputs['password']);
        }
        // Upload file and image
        if ($request->image != $employee->image){
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time()."image.".$ex;
            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$name);
            $image = $img_path.$employee->image;
            if (file_exists($image)){
                @unlink($image);
            }
        }
        else{
            $name = $employee->image;
        }

        // if ($request->file != $employee->file) {
        //     $strposFile = strpos($request->file,';');
        //     $subFile = substr($request->file, 0,$strposFile);
        //     $exFile = explode('/',$subFile)[1];
        //     $nameFile = time()."file.".$exFile;
        //     $imgFile = Image::make($request->file);
        //     $file_path = public_path()."/users/";
        //     $imgFile->save($file_path.$nameFile);
        //     $imageFile = $file_path.$employee->file;
        //     if (file_exists($imageFile)) {
        //         @unlink($imageFile);
        //     }
        // }
        // else{
        //     $nameFile = $employee->file;
        // }
        $inputs['image'] = $name;
        $employee->update($inputs);

        return response()->json(['success' => true, 'message' => 'Пользователь успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $employee = User::where('role_id', '!=', 1)->find($id);
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        //Delete User
        $employee->delete();
        return response()->json(['error' => true, 'message' => 'Пользователь удален']);
    }
}
