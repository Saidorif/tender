<?php

namespace App\Http\Controllers;

use App\Protocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProtocolController extends Controller
{
    public function index(Request $request)
    {
        $result = Protocol::with(['region'])->orderBy('id','DESC')->paginate(12);
        return response()->json(['success' => true,'result' => $result]);
    }

    public function edit(Request $request,$id)
    {
        $protocol = Protocol::with(['region'])->find($id);
        if(!$protocol){
            return response()->json(['error' => true,'message' => 'Протокол не найден']);
        }
        $user = $request->user();
        return response()->json(['success' => true,'result' => $protocol]);
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $protocol = Protocol::with(['region'])->where(['region_id' => $user->region_id])->orderBy('id','DESC')->get();
        return response()->json(['success' => true,'result' => $protocol]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs,[
            'number' => 'required|string',
            'date' => 'required|string',
            'file' => 'required|file|mimes:pdf,docx,doc,xls,xlsx',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs['region_id'] = $user->region_id;
        $inputs['created_by'] = $user->id;
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $protocol = Protocol::create($inputs);
        return response()->json(['success' => true,'message' => 'Протокол создан']);
    }

    public function update(Request $request,$id)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs,[
            'number' => 'required|string',
            'date' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,docx,doc,xls,xlsx',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $protocol = Protocol::find($id);
        if(!$protocol){
            return response()->json(['error' => true,'message' => 'Протокол не найден']);
        }
        $user = $request->user();
        $inputs['region_id'] = $user->region_id;
        $inputs['created_by'] = $user->id;
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $protocol->update($inputs);
        return response()->json(['success' => true,'message' => 'Протокол обновлен']);
    }

    public function destroy(Request $request,$id)
    {
        $protocol = Protocol::find($id);
        if(!$protocol){
            return response()->json(['error' => true,'message' => 'Протокол не найден']);
        }
        $user = $request->user();
        $protocol->delete();
        return response()->json(['success' => true,'message' => 'Протокол удален']);
    }
}
