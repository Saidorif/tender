<?php

namespace App\Http\Controllers;

use App\ContractCar;
use App\Direction;
use App\TenderLot;
use Illuminate\Http\Request;
use App\Contract;
use Illuminate\Support\Facades\Storage;
use Validator;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $contracts = Contract::orderBy('id','DESC')
                        ->with(['user','cars','protocol','region'])
                        ->where(['region_id' => $user->region_id])
                        ->paginate(12);
        return response()->json(['success' => true, 'result' => $contracts]);
    }

    public function edit(Request $request,$id)
    {
        $user = $request->user();
        $contract = Contract::with(['user','cars','protocol','region'])->where(['region_id' => $user->region_id])->find($id);
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
            'file' => 'required|file|mimes:pdf,PDF',
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
        $the_direction_err = [];
        foreach ($inputs['direction_ids'] as $d_id){
            $the_direction = Direction::find((int)$d_id);
            if(!$the_direction){
                $the_direction_err[] = 'Направление с ID = '.$d_id.' не существует';
            }
            if($the_direction->status == 'approved'){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->contract_id != null ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->status == 'busy' || $the_direction->reys_status == 'all' ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->reys_status == 'custom' ){
                $tenderLot = TenderLot::whereJsonContains('reys_id',$d_id)->first();
                if($tenderLot){
                    $the_direction_err[] = 'Направление с этими рейcами уже используется';
                }
            }
            if($the_direction->type_id != 1 && $the_direction->tarif == 0){
                $the_direction_err[] = 'Тариф направления равен нулю. Пожалуйста, заполните поле';
            }
            if(!$the_direction->requirement){
                return response()->json(['error' => true, 'message' => 'Требование не найдено в направлении '.$the_direction->name]);
            }
            if($the_direction->requirement->status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Требование не подтвержден '.$the_direction->name]);
            }
            if($the_direction->titul_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Титул не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xronom_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Хронометраж не подтвержден '.$the_direction->name]);
            }
            if($the_direction->sxema_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Схема не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xjadval_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'График движения не подтвержден '.$the_direction->name]);
            }
            if($user->role->name != 'admin'){
                if($the_direction->region_from_id != $user->region_id || $the_direction->region_to_id != $user->region_id ){
                    $the_direction_err[] = 'Нельзя добавить ... Направление в другом регионе';
                }
            }
        }
        if(count($the_direction_err)){
            return response()->json(['error' => true, 'message' => $the_direction_err]);
        }
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
//            if($ext != 'pdf' || $ext != 'PDF'){
//                return response()->json(['error' => true, 'message' => 'File must be pdf']);
//            }
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
        $user = $request->user();
        $contract = Contract::with(['user','lot','app'])->where(['region_id' => $user->region_id])->find($id);
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
        $the_direction_err = [];
        foreach ($inputs['direction_ids'] as $d_id){
            $the_direction = Direction::find((int)$d_id);
            if(!$the_direction){
                $the_direction_err[] = 'Направление с ID = '.$d_id.' не существует';
            }
            if($the_direction->status == 'approved'){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->contract_id != null ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->status == 'busy' || $the_direction->reys_status == 'all' ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->reys_status == 'custom' ){
                $tenderLot = TenderLot::whereJsonContains('reys_id',$d_id)->first();
                if($tenderLot){
                    $the_direction_err[] = 'Направление с этими рейcами уже используется';
                }
            }
            if($the_direction->type_id != 1 && $the_direction->tarif == 0){
                $the_direction_err[] = 'Тариф направления равен нулю. Пожалуйста, заполните поле';
            }
            if(!$the_direction->requirement){
                return response()->json(['error' => true, 'message' => 'Требование не найдено в направлении '.$the_direction->name]);
            }
            if($the_direction->requirement->status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Требование не подтвержден '.$the_direction->name]);
            }
            if($the_direction->titul_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Титул не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xronom_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Хронометраж не подтвержден '.$the_direction->name]);
            }
            if($the_direction->sxema_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Схема не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xjadval_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'График движения не подтвержден '.$the_direction->name]);
            }
            if($user->role->name != 'admin'){
                if($the_direction->region_from_id != $user->region_id || $the_direction->region_to_id != $user->region_id ){
                    $the_direction_err[] = 'Нельзя добавить ... Направление в другом регионе';
                }
            }
        }
        if(count($the_direction_err)){
            return response()->json(['error' => true, 'message' => $the_direction_err]);
        }
        //Upload file
        if($request->hasFile('file')){
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
//            if($ext != 'pdf' || $ext != 'PDF'){
//                return response()->json(['error' => true, 'message' => 'File must be pdf']);
//            }
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
        $user = $request->user();
        $contract = Contract::where(['region_id' => $user->region_id])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        foreach($contract->direction_ids as $direction){
            $direction->status = 'active';
            $direction->contract_id = null;
            $direction->save();
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

    public function activate(Request $request,$id)
    {
        $contract = Contract::find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        if($contract->status == 'completed'){
            return response()->json(['error' => true, 'message' => 'Контракт уже активирован']);
        }
        $the_direction_err = [];
        $user = $request->user();
        foreach($contract->direction_ids as $the_direction){
            if($the_direction->status == 'approved'){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->contract_id != null ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->status == 'busy' || $the_direction->reys_status == 'all' ){
                $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
            }
            if($the_direction->reys_status == 'custom' ){
                $tenderLot = TenderLot::whereJsonContains('reys_id',$the_direction->id)->first();
                if($tenderLot){
                    $the_direction_err[] = 'Направление с этими рейcами уже используется';
                }
            }
            if($the_direction->type_id != 1 && $the_direction->tarif == 0){
                $the_direction_err[] = 'Тариф направления равен нулю. Пожалуйста, заполните поле';
            }
            if(!$the_direction->requirement){
                return response()->json(['error' => true, 'message' => 'Требование не найдено в направлении '.$the_direction->name]);
            }
            if($the_direction->requirement->status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Требование не подтвержден '.$the_direction->name]);
            }
            if($the_direction->titul_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Титул не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xronom_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Хронометраж не подтвержден '.$the_direction->name]);
            }
            if($the_direction->sxema_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'Схема не подтвержден '.$the_direction->name]);
            }
            if($the_direction->xjadval_status != 'completed'){
                return response()->json(['error' => true, 'message' => 'График движения не подтвержден '.$the_direction->name]);
            }
            if($user->role->name != 'admin'){
                if($the_direction->region_from_id != $user->region_id || $the_direction->region_to_id != $user->region_id ){
                    $the_direction_err[] = 'Нельзя добавить ... Направление в другом регионе';
                }
            }
        }
        if(count($the_direction_err)){
            return response()->json(['error' => true, 'message' => $the_direction_err]);
        }
        foreach($contract->direction_ids as $direction){
            $direction->status = 'busy';
            $direction->contract_id = $contract->id;
            $direction->save();
        }
        $contract->status = 'completed';
        $contract->save();
        return response()->json(['success' => true,'message' => 'Контракт активирован']);
    }
}
