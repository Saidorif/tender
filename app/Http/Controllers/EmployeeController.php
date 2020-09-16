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
                ->with(['role','position']);
        }
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['name'])){
                $builder->where('name','LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['position_id'])){
                $builder->where(['position_id' => $params['position_id']]);
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
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        return response()->json(['success' => true, 'message' => 'Электронная почта свободно для использования']);
    }

    public function edit($id)
    {
        // $user = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $user = User::with(['role','position','experience'])->find($id);
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
            'region_id'    => 'required|integer',
            'area_id'      => 'required|integer',
            'role_id'      => ['required',Rule::in($role_ids),],
            'position_id'  => 'required|integer',
            'phone'        => 'required|min:12',
            'password'     => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'email'      => 'required|unique:users,email|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
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
        // $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $employee = User::where(['id' => $id])->first();
        $employee = User::findOrFail($id);
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'status'                    => ['required',Rule::in(['active', 'inactive']),],
            'gender'                    => ['required',Rule::in(['male', 'female']),],
            'name'                      => 'required|string',
            'email'                     => 'required|email|unique:users,email,'.$employee->id,
            'password'                  => 'required|string|min:6',
            'confirm_password'          => 'required|string|min:6',
            'role_id'                   => 'required|integer',
            'position_id'               => 'required|integer',
            'role_id'                   => 'required|integer',
            'image'                     => 'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
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

        if ($request->file != $employee->file) {
            $strposFile = strpos($request->file,';');
            $subFile = substr($request->file, 0,$strposFile);
            $exFile = explode('/',$subFile)[1];
            $nameFile = time()."file.".$exFile;
            $imgFile = Image::make($request->file);
            $file_path = public_path()."/users/";
            $imgFile->save($file_path.$nameFile);
            $imageFile = $file_path.$employee->file;
            if (file_exists($imageFile)) {
                @unlink($imageFile);
            }
        }
        else{
            $nameFile = $employee->file;
        }
        $inputs['image'] = $name;
        $inputs['file'] = $nameFile;
        $employee->update($inputs);

        //Update user experience
        if(!empty($inputs['experience'])){
            $exps = $employee->experience;
            foreach ($exps as $key => $value) {
                $value->delete();
            }
            foreach ($inputs['experience'] as $key => $item) {
                $item['user_id'] = $employee->id;
                $experience = UserExperience::create($item);
            }
        }

        return response()->json(['success' => true, 'message' => 'Пользователь успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }

        $exps = $employee->experience;
        //Delete User
        $employee->delete();
        //Delete user experience
        foreach ($exps as $key => $value) {
            $value->delete();
        }
        return response()->json(['error' => true, 'message' => 'Пользователь удален']);
    }
}
