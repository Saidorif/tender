<?php

namespace App\Http\Controllers;

use App\Appeal;
use App\Application;
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
        $type = 'old';
        if(!empty($request->input('type'))){
            $type = $request->input('type');
        }
        $builder = Contract::query()->orderBy('id','DESC')
                        ->with(['user','cars','protocol','region'])
                        ->where(['type' => $type]);
        if($user->role_id != 1){
            $builder->where(['region_id' => $user->region_id]);
        }
        $contracts = $builder->paginate(12);
        return response()->json(['success' => true, 'result' => $contracts]);
    }

    public function userIndex(Request $request)
    {
        $user = $request->user();
        $contracts = Contract::orderBy('id','DESC')
            ->with(['user','cars','region'])
            ->where('user_id', '=', $user->id)
            ->paginate(12);
        return response()->json(['success' => true,'result' => $contracts]);
    }

    public function userList(Request $request)
    {
        $user = $request->user();
        $contracts = Contract::orderBy('id','DESC')
            ->with(['user','cars','region'])
            ->where('user_id', '=', $user->id)
            ->get();
        return response()->json(['success' => true,'result' => $contracts]);
    }

    public function appealIndex(Request $request)
    {
        $user = $request->user();
        $appeals = Appeal::orderBy('id','DESC')
            ->with(['user','contract','region'])
            ->where('region_id', '=', $user->region_id)
            ->paginate(12);
        return response()->json(['success' => true,'result' => $appeals]);
    }

    public function appealUser(Request $request)
    {
        $user = $request->user();
        $appeals = Appeal::orderBy('id','DESC')
            ->with(['user','contract','region'])
            ->where('user_id', '=', $user->id)
            ->paginate(12);
        return response()->json(['success' => true,'result' => $appeals]);
    }

    public function appealUserEdit(Request $request,$id)
    {
        $user = $request->user();
        $appeals = Appeal::with(['user','contract','region'])
            ->where('user_id', '=', $user->id)
            ->where('id', '=', $id)
            ->first();
        if(!$appeals){
            return  response()->json(['error' => true,'message' => 'Сообщение не найдено']);
        }
        return response()->json(['success' => true,'result' => $appeals]);
    }

    public function appealEdit(Request $request,$id)
    {
        $user = $request->user();
        $appeals = Appeal::with(['user','contract','region'])
            ->where('region_id', '=', $user->region_id)
            ->where('id', '=', $id)
            ->first();
        if(!$appeals){
            return  response()->json(['error' => true,'message' => 'Сообщение не найдено']);
        }
        return response()->json(['success' => true,'result' => $appeals]);
    }

    public function appealStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'contract_id' => 'required|integer',
            'type' => 'required|string',
            'text' => 'nullable|string',
            'user_file' => 'required|file',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
        $inputs['company_name'] = $user->company_name;
        $inputs['region_id'] = $user->region_id;
        $inputs['date'] = date('Y-m-d H:m:s');
        $inputs['status'] = 'pending';

        //Upload file
        if($request->hasFile('user_file')){
            $file = $request->file('user_file');
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['user_file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $appeal = Appeal::create($inputs);
        return response()->json(['success' => true,'message' => 'Сообщение успешно отправлено']);
    }

    public function appealApprove(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'appeal_id' => 'required|integer',
            'answer_text' => 'required|string',
            'answer_file' => 'required|file',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $user = $request->user();
        $appeal = Appeal::with(['user','contract','region'])->find($inputs['appeal_id']);
        if(!$appeal){
            return  response()->json(['error' => true,'message' => 'Сообщение не найдено']);
        }
        if($appeal->status == 'completed'){
            return  response()->json(['error' => true,'message' => 'Сообщение уже одобрен']);
        }
        if($user->role->name != 'admin'){
            if($user->region_id != $appeal->region_id){
                return  response()->json(['error' => true,'message' => 'У вас нет доступа']);
            }
        }
        $inputs['approved_by'] = $user->id;
        $inputs['approved_date'] = date('Y-m-d H:m:s');
        $inputs['status'] = 'completed';

        //Upload file
        if($request->hasFile('answer_file')){
            $file = $request->file('answer_file');
            $path = 'public/'.date('Y-m-d');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs($path, $file,$file_name);
            $inputs['answer_file'] = 'storage/'.date('Y-m-d').'/'.$file_name;
        }
        $appeal->update($inputs);
        return  response()->json(['success' => true,'message' => 'Сообщение одобрен']);
    }

    public function activateChangedDirection(Request $request,$id)
    {
        $inputs = $request->all();
        $user = $request->user();
        $appeal = Appeal::find($id);
        if(!$appeal){
            return  response()->json(['error' => true,'message' => 'Сообщение не найдено']);
        }
        $inputs['status'] = 'activated';
        $appeal->update($inputs);
        return  response()->json(['success' => true,'message' => 'Направление одобрен']);
    }

    public function sendDirectionChangeToAppeal(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $contract = Contract::where(['status' => 'active'])->whereJsonContains('direction_ids',[$direction->id])->first();
        if($contract){
            //Yonalishlarda ozgarishlar kiritish togrisida ariza kelib tushganmi yoqmi
            $appeal = Appeal::where('status','=','pending')->where('type','=','changed')->first();
            if($appeal){
                $appeal->status = 'approved';
                $appeal->save();
                return response()->json(['success' => true,'message' => 'Request sent to user for activation']);
            }
        }
        return response()->json(['error' => true,'message' => 'Контракт не найден']);
    }

    public function userAgreement(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'contract_id' => 'required|integer',
            'agree' => 'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $contract = Contract::where('id','=',$inputs['contract_id'])->where('user_id','=',$user->id)->first();
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        $agree = (int)$inputs['agree'];
        if($agree){
            $contract->agree = $agree;
            $contract->status = 'active';
            $contract->agree_date = date('Y-m-d H:m:s');
            $contract->save();
            return response()->json(['success' => true, 'message' => 'Контракт активирован']);
        }else{
            //Change application, lot, direction
            $application = $contract->app;
            $application->status = 'reject';
            $application->tender_status = 'reject';
            $application->save();

            //get other apps and change statuses
            $apps = Application::where('lot_id','=',$application->lot_id)->get();
            if(count($apps) > 0){
                foreach ($apps as $app) {
                    $app->status = 'accepted';
                    $app->save();
                }
            }

            //Change lot status
            $lot = $application->lot;
            $lot->status = 'pending';
            $lot->save();

            //Change contract status
            $contract->agree = 2;
            $contract->status = 'reject';
            $contract->agree_date = date('Y-m-d H:m:s');
            $contract->save();
            return response()->json(['success' => true, 'message' => 'Контракт деактивирован']);
        }
    }

    public function edit(Request $request,$id)
    {
        $user = $request->user();
        $contract = Contract::with(['user','cars','protocol','region'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        if($user->role_id != 1 && $user->region_id != $contract->region_id){
            return response()->json(['error' => true, 'message' => 'Контракт не найден']);
        }
        return response()->json(['success' => true, 'result' => $contract]);
    }

    public function userEdit(Request $request,$id)
    {
        $user = $request->user();
        $contract = Contract::with(['user','cars','region'])->where(['user_id' => $user->id])->find($id);
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
        if(!$contract->status == 'completed'){
            return response()->json(['error' => true, 'message' => 'Контракт уже активирован']);
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
