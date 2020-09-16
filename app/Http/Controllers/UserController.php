<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;
use App\Permission;
use App\User;
use JWTAuth;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $employee = User::with(['role','position'])->find($user->id);
        $pers = [];
        $permissions = Permission::where(['role_id' => $user->role->id])->with(['controller', 'action'])->get();
        foreach($permissions as $k => $permission){
            $pers[$k]['action'] = $permission->action->code;
            $pers[$k]['subject'] = $permission->controller->name;
        }
        $pers = array_unique($pers, SORT_REGULAR);
        $pers = array_values($pers);
        $result['permissions'] = $pers;
        $result['user'] = $employee;
        return response()->json(['success' => true, 'result' => $result]);
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

        if ($request->file != $user->file) {
            $strposFile = strpos($request->file,';');
            $subFile = substr($request->file, 0,$strposFile);
            $exFile = explode('/',$subFile)[1];
            $nameFile = time()."file.".$exFile;
            $imgFile = Image::make($request->file);
            $file_path = public_path()."/users/";
            $imgFile->save($file_path.$nameFile);
            $imageFile = $file_path.$user->file;
            if (file_exists($imageFile)) {
                @unlink($imageFile);
            }
        }
        else{
            $nameFile = $user->file;
        }
        $inputs['image'] = $name;
        $inputs['file'] = $nameFile;
        unset($inputs['password']);
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'region_id'      => 'required|integer',
            'area_id'      => 'required|integer',
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
}
