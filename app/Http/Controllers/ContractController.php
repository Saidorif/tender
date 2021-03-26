<?php

namespace App\Http\Controllers;

use App\ContractCar;
use Illuminate\Http\Request;
use App\Contract;
use Illuminate\Support\Facades\Storage;
use Validator;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::orderBy('id','DESC')->with(['user','cars','protocol','region'])->paginate(12);
        return response()->json(['success' => true, 'result' => $contracts]);
    }

    public function edit(Request $request,$id)
    {
        $contract = Contract::with(['user','cars','protocol','region'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        return response()->json(['success' => true, 'result' => $contract]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'number' => 'required|string',
            'date' => 'required|date',
            'exp_date' => 'required|date',
            'contract_period' => 'required|integer',
            'direction_ids' => 'required|array',
            'direction_ids.*' => 'required|integer',
            'protocol_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf',
            'cars' => 'required|array',
            'cars.*.auto_number' => 'required|string',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.busmodel_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
            'cars.*.busmarka_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['region_id'] = $user->region_id;
        $inputs['created_by'] = $user->id;
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
        //Store cars
        if(!empty($inputs['cars'])){
            foreach ($inputs['cars'] as $car){
                $car['contract_id'] = $contract->id;
                $car['user_id'] = $inputs['user_id'];
                $contractCar = ContractCar::create($car);
            }
        }
        return response()->json(['success' => true, 'message' => 'Контракт создан']);
    }

    public function update(Request $request,$id)
    {
        $contract = Contract::with(['user','lot','app'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'number' => 'required|string',
            'date' => 'required|date',
            'exp_date' => 'required|date',
            'contract_period' => 'required|integer',
            'direction_ids' => 'required|array',
            'direction_ids.*' => 'required|integer',
            'protocol_id' => 'required|integer',
            'cars' => 'required|array',
            'cars.*.auto_number' => 'required|string',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.busmodel_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
            'cars.*.busmarka_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        unset($inputs['file']);
        $inputs['region_id'] = $user->region_id;
        $inputs['created_by'] = $user->id;
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
        //Store cars
        if(!empty($inputs['cars'])){
            foreach ($inputs['cars'] as $car){
                $car['contract_id'] = $contract->id;
                $car['user_id'] = $inputs['user_id'];
                if(!empty($car['id']) && is_int((int)$car['id']) && $car['id'] != 'undefined' ){
                    $contractCar = ContractCar::find((int)$car['id']);
                    if($contractCar){
                        $contractCar->update($car);
                    }
                }else{
                    $contractCar = ContractCar::create($car);
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Контракт обновлен']);
    }

    public function destroy(Request $request,$id)
    {
        $contract = Contract::find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        $contract->cars()->delete();
        $contract->delete();
        return response()->json(['success' => true, 'message' => 'Контракт удален']);
    }

    public function carDestroy(Request $request,$id)
    {
        $contractCar = ContractCar::find($id);
        if(!$contractCar){
            return response()->json(['error' => true, 'message' => 'Автомобиль не найден']);
        }
        $contractCar->delete();
        return response()->json(['success' => true, 'message' => 'Автомобиль удален']);
    }
}
