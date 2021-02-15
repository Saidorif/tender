<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Application;
use App\Tender;
use App\UserCar;
use App\Direction;
use App\User;
use Str;

class ApplicationController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        if($user->role->name == 'admin'){
            $result = Application::orderBy('id', 'DESC')->with(['user','carsWith','lots','attachment'])->paginate(12);
        }else{
            //grab the user ids in this region
            $user_ids = User::where(['region_id' => $user->region_id,'role_id' => 9])->pluck('id')->toArray();
            $result = Application::orderBy('id', 'DESC')
                            ->with(['user','carsWith','lots','attachment'])
                            ->whereIn('user_id', $user_ids)
                            ->paginate(12);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tarif' => 'nullable|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
        $application = Application::create($inputs);
        return response()->json([
            'success' => true,
            'result' => $application,
            'message' => 'Заявка создано'
        ]);
    }

    public function storeFromTenders(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tender_id' => 'required|integer',
            'lot_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('tender_id','lot_id');
        $tender = Tender::find($inputs['tender_id']);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        if($tender->status != 'completed'){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не подтвержден']);
        }
        $user = $request->user();
        //Check for if already sent application to this lot
        $the_old_app = Application::where(['lot_id' => $inputs['lot_id'],'user_id' => $user->id])->first();
        if($the_old_app){
            return response()->json(['error' => true, 'message' => 'Вы уже отправляли заявку на этот лот','result' => $the_old_app->id]);
        }
        $inputs['user_id'] = $user->id;
        $direction_ids = [];
        foreach($tender->direction_ids as $key => $direction){
            $direction_ids[] = $direction['id'];
        }
        // print_r($direction_ids);die;
        $inputs['direction_ids'] = $direction_ids;
        $application = Application::create($inputs);
        return response()->json([
            'success' => true,
            'result' => $application,
            'message' => 'Заявка создано'
        ]);
    }

    public function carStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'auto_number' => 'required|string',
            'app_id' => 'required|integer',
            'tender_id' => 'nullable|integer',
            'bustype_id' => 'required|integer',
            'busmodel_id' => 'required|integer',
            'tclass_id' => 'required|integer',
            'busmarka_id' => 'required|integer',
            // 'qty_reys' => 'required|integer',
            'capacity' => 'required|integer',
            'seat_qty' => 'required|integer',
            'date' => 'required|integer|min:1900|max:'.date('Y'),
            'conditioner' => 'required|boolean',
            'internet' => 'required|boolean',
            'bio_toilet' => 'required|boolean',
            'bus_adapted' => 'required|boolean',
            'telephone_power' => 'required|boolean',
            'monitor' => 'required|boolean',
            'station_announce' => 'nullable|boolean',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
        $inputs['auto_number'] = strtoupper($inputs['auto_number']);
        //Check for if the car already in use
        $the_old_car = UserCar::where(['auto_number' => $inputs['auto_number']])->first();
        if($the_old_car){
            return response()->json(['error' => true, 'message' => 'Автомобиль уже используется']);
        }
        $result = UserCar::create($inputs);
        return response()->json([
            'success' => true,
            'result' => $result,
            'message' => 'Автотранспорт создано'
        ]);
    }

    public function carDestroy(Request $request,$id)
    {
        $user = $request->user();
        $car = UserCar::find($id);
        if(!$car){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не найдено']);
        }
        if($user->id != $car->user_id){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не найдено']);
        }
        if($car->application->status == 'accepted'){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не может быт удалено']);
        }
        if($car->gai){
            $car->gai->delete();
        }
        if($car->adliya){
            $car->adliya->delete();
        }
        $car->delete();
        return response()->json(['success' => true, 'message' => 'Автотранспорт удалено']);
    }

    public function edit(Request $request, $id)
    {
        $application = Application::with(['user','carsWith','tender','attachment','lots'])->find($id);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        return response()->json(['success' => true, 'result' => $application]);
    }

    public function update(Request $request, $id)
    {
        $application = Application::find($id);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        if($application->status == 'accepted'){
            return response()->json(['error' => true, 'message' => 'Application already accepted...']);
        }
        $validator = Validator::make($request->all(),[
            'tender_id' => 'required|integer',
            'tarif' => 'required|integer',
            'status' => 'nullable|string',
            'daily_technical_job' => 'nullable|boolean',
            'daily_medical_job' => 'nullable|boolean',
            'hours_rule' => 'nullable|boolean',
            'videoregistrator' => 'nullable|boolean',
            'gps' => 'nullable|boolean',
            'qty_reys' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs['status'] = 'active';
        $application->update($inputs);
        return response()->json(['success' => true, 'message' => 'Заявка обновлено']);
    }

    public function activate(Request $request, $id)
    {
        $application = Application::find($id);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        if($application->status == 'accepted'){
            return response()->json(['error' => true, 'message' => 'Заявка уже принята']);
        }
        if($application->cars->count() < 1){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, добавьте машину']);
        }
        if($application->tarif < 1 ){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, заполните тариф']);
        }
        if($application->qty_reys < 1 ){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, заполните количество рейсов']);
        }
        //check for direction cars count
        $lot = $application->lots;
        $requirement_cars_count = 0;
        $directions = Direction::whereIn('id',$lot->getDirection())->get();
        foreach($directions as $dir){
            $requirement_cars_count += $dir->requirement->auto_trans_count;
        }
        if($requirement_cars_count > $application->cars->count()){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, добавьте ещё '.($requirement_cars_count - $application->cars->count()).' машин']);
        }
        $text = $application->user->company_name."\n";
        $text .= "ДАТА: ".$application->tender->time."\n";
        $the_file = time().'_'.$application->id;
        $qrcode = \QrCode::encoding('UTF-8')->format('png')->size(200)->generate($text, public_path('qrcodes/'.$the_file.'.png'));

        //Update application
        $application->qr_code = 'qrcodes/'.$the_file.'.png';
        $application->status = 'accepted';
        $application->save();
        return response()->json(['success' => true, 'message' => 'Application accepted','result' => $application->qr_code]);
    }

    public function setStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'car_id' => 'required|integer',
            'app_id' => 'required|integer',
            'status' => ['required',Rule::in(['rejected','accepted']),],
            'technical_status' => ['nullable',Rule::in([0,1]),],
            'text' => 'nullable|string',
            // 'file' => 'nullable|file',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $car = UserCar::where(['id' => $inputs['car_id'],'app_id' => $inputs['app_id']])->first();
        if(!$car){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не найдено']);
        }
        // if($car->status == 'rejected' || $car->status == 'accepted'){
        //     return response()->json(['error' => true, 'message' => 'Статус автотранспорта уже изменен']);
        // }
        //Upload file
        if($request->hasFile('file')){
            $path = public_path('usercars');
            $file = $request->file('file');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $inputs['file'] = '/usercars/'.$fileName;
            $car->file = $inputs['file'];
            $car->save();
        }
        $car->update($inputs);
        return response()->json(['success' => true, 'message' => 'Статус автотранспорта изменен']);
    }
}