<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Appfile;

class AppfileController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_id' => 'required|integer',
            'type' => 'required|string',
            'car_id' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','message'=>$validator->messages()], 400);
        }
        $inputs = $request->all();
        $builder = Appfile::query()->where(['app_id' => $inputs['app_id'],'type' => $inputs['type']]);
        if(!empty($inputs['car_id'])){
            $builder->where(['car_id' => $inputs['car_id']]);
        }
        $result = $builder->get();
        return response()->json(['success' => true,'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpeg,jpg,png',
            'app_id' => 'required|integer',
            'type' => 'required|string',
            'car_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true,'message'=>$validator->messages()], 400);
        }

        $file = $request->file('file');
        $inputs = $request->all();
        $path = 'public/'.date('Y-m-d');
        $file_name = time().'.'.$file->getClientOriginalExtension();
        Storage::disk('local')->putFileAs($path, $file,$file_name);
        $inputs['file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        $appFile = Appfile::create($inputs);
        return response()->json(['success' => true,'message' => 'File created successfully']);
    }

    public function destroy(Request $request,$id)
    {
        $appFile = Appfile::find($id);
        if(!$appFile){
            return response()->json(['error' => true,'message' => 'File not found']);
        }
        $appFile->delete();
        return response()->json(['success' => true,'message' => 'File deleted successfully']);
    }
}
