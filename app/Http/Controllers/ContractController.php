<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use Illuminate\Support\Facades\Storage;
use Validator;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::orderBy('id','DESC')->with('user')->paginate(12);
        return response()->json(['success' => true, 'result' => $contracts]);
    }

    public function edit(Request $request,$id)
    {
        $contract = Contract::with(['user','lot','app'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        return response()->json(['success' => true, 'result' => $contract]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'number' => 'required|string',
            'date' => 'required|date',
            'exp_date' => 'required|date',
            'contract_period' => 'required|integer',
            'direction_ids' => 'required|array',
            'direction_ids.*' => 'required|integer',
            'protocol_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['region_id'] = $user->region_id;
        $inputs['user_id'] = $user->id;
        $inputs['type'] = 'old';
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            if($ext != 'pdf'){
                return response()->json(['error' => true, 'message' => 'File must be pdf']);
            }
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $contract = Contract::create($inputs);
        return response()->json(['success' => true, 'message' => 'Контракт создан']);
    }

    public function update(Request $request,$id)
    {
        $contract = Contract::with(['user','lot','app'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        $validator = Validator::make($request->all(),[
            'number' => 'required|string',
            'date' => 'required|date',
            'exp_date' => 'required|date',
            'contract_period' => 'required|integer',
            'direction_ids' => 'required|array',
            'direction_ids.*' => 'required|integer',
            'protocol_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        unset($inputs['file']);
        $inputs['region_id'] = $user->region_id;
        $inputs['user_id'] = $user->id;
        $inputs['type'] = 'old';
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            if($ext != 'pdf'){
                return response()->json(['error' => true, 'message' => 'File must be pdf']);
            }
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $contract->update($inputs);
        return response()->json(['success' => true, 'message' => 'Контракт обновлен']);
    }
}
