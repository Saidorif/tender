<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Validator;
use Image;

class SettingController extends Controller
{
    public function salary()
    {
        $setting = Setting::first();
        return response()->json(['success' => true, 'result' => $setting->salary]);
    }
    
    public function logo()
    {
        $setting = Setting::first();
        return response()->json(['success' => true, 'logo' => $setting->logo]);
    }
    
    public function index(Request $request)
    {
        $setting = Setting::first();
        return response()->json(['success' => true, 'result' => $setting]);
    }
    
    public function update(Request $request)
    {
        $user = $request->user();
        $role = $user->role->name;
        $validator = Validator::make($request->all(),[
            'email' => 'nullable|email',
            'salary' => 'nullable|numeric',
            'name' => 'nullable|string',
            'bank_number' => 'nullable|string',
            'city' => 'nullable|string',
            'oked' => 'nullable|string',
            'mfo' => 'nullable|string',
            'inn' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => "Адрес электронной почты должен быть действительным адресом электронной почты!"]);
        }
        $setting = Setting::first();
        // logo image start
        if ($request->logo != $setting->logo) {

            $strposLogo = strpos($request->logo,';');
            $subLogo = substr($request->logo, 0,$strposLogo);
            $exLogo = explode('/',$subLogo)[1];
            $logoName = time().$exLogo;
            $imgLogo = Image::make($request->logo);
            $imgLogo_path = public_path()."/settingImages/";
            $imgLogo->save($imgLogo_path.$logoName);

            $image = $imgLogo_path.$setting->logo;
            if (file_exists($image)) {
                @unlink($image);
            }

        }
        else{
            $logoName = $setting->logo;
        }
        // logo image end 
        // favicon image start
        if ($request->favicon != $setting->favicon) {

            $strposFavicon = strpos($request->favicon,';');
            $sub = substr($request->favicon, 0,$strposFavicon);
            $ex = explode('/',$sub)[1];
            $logoFavicon = "favicon.".$ex;

            $img = Image::make($request->favicon);
            $img_path = public_path()."/settingImages/";
            $img->save($img_path.$logoFavicon);

            $image = $img_path.$setting->favicon;
            if (file_exists($image)) {
                @unlink($image);
            }

        }
        else{
            $logoFavicon = $setting->favicon;
        }
        // favicon image end
        $inputs = $request->all();
        $inputs['logo'] = $logoName;
        $inputs['favicon'] = $logoFavicon;
        $inputs['updated_by'] = $user->id;
        $setting->update($inputs);
        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }
}
