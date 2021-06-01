<?php

namespace App\Http\Controllers;

use App\ClientAccess;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Storage;
use Image;
use Hash;
use Illuminate\Support\Str;

class ClientAccessController extends Controller
{

    public function index(Request $request)
    {
        $params = $request->all();
        $user = $request->user();
        $user_ids = User::where(['role_id' => 9,'region_id' => $user->region_id])->get()->pluck('id')->toArray();
        $builder = ClientAccess::query();
        if(!empty($params['inn'])){
            $builder->where(['inn' => $params['inn']]);
        }
        $clientAccess = $builder->whereIn('user_id',$user_ids)->orderBy('status','DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $clientAccess]);
    }


    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'users' => 'required|array',
            'users.*.id' => 'required|integer',
            'users.*.email' => 'required|unique:users,email|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        foreach($request->input('users') as $item){
            $clientAccess = ClientAccess::find($item['id']);
            if($clientAccess){
                $user = $clientAccess->user;
                if($user){
                    $password = Str::random(8);
                    $user->email = $item['email'];
                    $user->password = Hash::make($password);
                    $user->save();
                    $data = array(
                        'email' => $user->email,
                        'name' => $user->name,
                        'login' => $user->email,
                        'password' => $password,
                    );
                    \Mail::send('emails.login',$data, function ($message) use ($data) {
                        $message->from('info@mintrans.uz','mintrans.uz');
                        $message->to($data["email"]);
                        $message->subject('Данные для входа!');
                    });
                    $clientAccess->status = 'active';
                    $clientAccess->save();
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Emails updated']);
    }


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        foreach($request->input('ids') as $item){
            $clientAccess = ClientAccess::find($item);
            if($clientAccess){
                if($clientAccess->status != 'active'){
                    $clientAccess->delete();
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Client Accesses deleted']);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inn' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        if(!$request->file){
            return response()->json(['error' => true, 'message' => 'Please upload file']);
        }
        $inn = $request->input('inn');
        $user = User::where(['inn' => $inn])->first();
        //role tashuvchi
        if($user && $user->role->id == 9){
            $strpos = strpos($request->file,';');
            $sub = substr($request->file, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time().".".$ex;

            $img = Image::make($request->file);
            $img_path = public_path()."/uploads/";
            $img->save($img_path.$name);

            $clientAccess = new ClientAccess();
            $clientAccess->inn = $user->inn;
            $clientAccess->user_id = $user->id;
            $clientAccess->file = $name;
            $clientAccess->created_by = $user->id;
            $clientAccess->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => true]);

    }

}
