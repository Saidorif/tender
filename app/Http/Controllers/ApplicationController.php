<?php

namespace App\Http\Controllers;

use App\AdliyaCar;
use App\Certificate;
use App\DirectionReq;
use App\GaiCar;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Application;
use App\Tender;
use App\UserCar;
use App\Direction;
use App\DirectionCar;
use App\TenderLot;
use App\User;
use Str;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::where(['status' => 'completed'])
                    //->where('time','<',now())
                    ->paginate(12);
        return response()->json(['success' => true, 'result' => $tenders]);
    }

    public function userIndex(Request $request)
    {
        $user = $request->user();
        $tenders = Application::where(['user_id' => $user->id])->with(['user','carsWith','lots','attachment'])->paginate(12);
        return response()->json(['success' => true, 'result' => $tenders]);
    }

    public function userShow(Request $request,$id)
    {
        $user = $request->user();
        $application = Application::where(['user_id' => $user->id,'id' => $id])->with(['user','carsWith','lots','attachment'])->first();
        return response()->json(['success' => true, 'result' => $application]);
    }

    public function show(Request $request,$id)
    {
        $user = $request->user();
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        if($user->role->name == 'admin'){
            $result = Application::orderBy('id', 'DESC')
                ->with(['carsWith','lots'])
                ->select('id','status','lot_id','tender_id')
                ->where(['tender_id' => $id,'status' => 'accepted'])
                ->paginate(12);
        }else{
            //grab the user ids in this region
            $user_ids = User::where(['region_id' => $user->region_id,'role_id' => 9])->pluck('id')->toArray();
            $result = Application::orderBy('id', 'DESC')
                ->with(['carsWith','lots'])
                ->select('id','status','lot_id','tender_id')
                ->whereIn('user_id', $user_ids)
                ->where(['tender_id' => $id])
                ->paginate(12);
        }
        if($tender->time > date('Y-m-d H:m:s')){
            $result->map(function ($item) {
                $item->unsetRelation('carsWith');
                $item->cars_with = [];
                return $item;
            });
        }
        return response()->json(['success' => true, 'result' => $result,'tender' => $tender]);
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
        $lot = TenderLot::find($inputs['lot_id']);
        if(!$lot){
            return response()->json(['error' => true, 'message' => 'Лот не найден']);
        }
        if($tender->status != 'completed'){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не подтвержден']);
        }
        if($tender->time < now()){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере завершен']);
        }

        $user = $request->user();
        //Check for if already sent application to this lot
        $the_old_app = Application::where(['lot_id' => $inputs['lot_id'],'user_id' => $user->id])->first();
        if($the_old_app){
            return response()->json(['error' => true, 'message' => 'Вы уже отправляли заявку на этот лот','result' => $the_old_app->id,'type' => 'old']);
        }
        $salary = getAppFee();
        if($user->balance < $salary){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, оплатите регистрационный сбор ('.$user->balance.')']);
        }
        $inputs['user_id'] = $user->id;
        $inputs['direction_ids'] = $lot->getDirection();
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
            'direction_id' => 'required|integer',
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

        $application = Application::find($inputs['app_id']);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Заявка не найдена']);
        }
        $tender_lot = TenderLot::find($application->lot_id);
        if(!$tender_lot){
            return response()->json(['error' => true, 'message' => 'Лот не найден']);
        }
        //check for bustype_id is equal
        $dir_cars = DirectionCar::whereIn('direction_id',$tender_lot->getDirection())->pluck('bustype_id')->toArray();
        if(!in_array($inputs['bustype_id'],$dir_cars)){
            return response()->json(['error' => true, 'message' => 'Категория Авто не совпадает']);
        }
        //check for tclass_id is equal
        $dir_klass = DirectionCar::whereIn('direction_id',$tender_lot->getDirection())->pluck('tclass_id')->toArray();
        if(!in_array($inputs['tclass_id'],$dir_klass)){
            return response()->json(['error' => true, 'message' => 'Класс Авто не совпадает']);
        }
        // Get auto_trans_count from requirements
        $dir_reqs = DirectionReq::where('direction_id',$inputs['direction_id'])->first();//->auto_trans_count;
        if(!$dir_reqs){
            return response()->json(['error' => true, 'message' => 'Направления не найден']);
        }
        $lot = $application->lots;
        $requirement_cars_count = 0;
        $the_direction = Direction::find($inputs['direction_id']);
        if(!$the_direction){
            return response()->json(['error' => true, 'message' => 'Направления не найден']);
        }
        $requirement_cars_count = $dir_reqs->auto_trans_count;
        if($the_direction->reys_status == 'all'){
            $requirement_cars_count = $dir_reqs->auto_trans_count;
        }
        elseif($the_direction->reys_status == 'custom'){
            $requirement_cars_count = $dir_reqs->auto_trans_count_from;
        }
        $the_cars_count = UserCar::where(['app_id' => $application->id,'direction_id' => $inputs['direction_id']])->get()->count();
        if($requirement_cars_count <= $the_cars_count){
            return response()->json(['error' => true, 'message' => 'Вы уже добавили достаточно машин на эту направлению']);
        }

        $inputs['user_id'] = $user->id;
        $inputs['auto_number'] = strtoupper($inputs['auto_number']);
        //Check for if the car already in use
        $the_old_car = UserCar::where(['auto_number' => $inputs['auto_number']])->first();
        if($the_old_car){
            return response()->json(['error' => true, 'message' => 'Автомобиль уже используется']);
        }

        //Check for GAI CAR
        $gai_car = GaiCar::where(['pPlateNumber' => $inputs['auto_number']])->first();
        $adliya_car = AdliyaCar::where(['auto_number' => $inputs['auto_number']])->first();
        if(!$gai_car && !$adliya_car){
            return response()->json(['error' => true, 'message' => 'Автомобиль не проверен']);
        }
        //Check for made year
        if($gai_car){
            if($gai_car->pMadeofYear != $inputs['date']){
                return response()->json(['error' => true, 'message' => 'Год выпуска автомобиля не совпадает']);
            }
            if($gai_car->user_id != $user->id){
                return response()->json(['error' => true, 'message' => 'Владелец автомобиля не соответствует']);
            }
        }
        //Check for made year for category (M1,M2,M3)
        $the_year = date('Y') - $inputs['date'];
        if($inputs['bustype_id'] == 3 && $the_year > 14){
            return response()->json(['error' => true, 'message' => 'Год выпуска автомобиля не должно быть больше от '.$the_year]);
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
        if($application->tender->time > date('Y-m-d H:m:s') && $application->status == 'accepted'){
            return response()->json(['error' => true, 'message' => 'Tender is not complete yet']);
        }
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
            'tarif' => 'required|array',
            'tarif.*.direction_id' => 'required|integer',
            'tarif.*.summa' => 'required|integer',
            'status' => 'nullable|string',
            'daily_technical_job' => 'nullable|boolean',
            'daily_medical_job' => 'nullable|boolean',
            'hours_rule' => 'nullable|boolean',
            'videoregistrator' => 'nullable|boolean',
            'gps' => 'nullable|boolean',
            'qty_reys' => 'required|array',
            'qty_reys.*.direction_id' => 'required|integer',
            'qty_reys.*.qty' => 'required|integer',
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
//        if($application->qty_reys < 1 ){
//            return response()->json(['error' => true, 'message' => 'Пожалуйста, заполните количество рейсов']);
//        }
        //check for direction cars count
        $lot = $application->lots;
        $requirement_cars_count = 0;
        $directions = Direction::whereIn('id',$lot->getDirection())->get();
        foreach($directions as $dir){
            if($dir->reys_status == 'all'){
                $requirement_cars_count += $dir->requirement->auto_trans_count;
            }
            if($dir->reys_status == 'custom'){
                $requirement_cars_count += $dir->requirement->auto_trans_count_from;
            }
        }
        if($requirement_cars_count > $application->cars->count()){
            return response()->json(['error' => true, 'message' => 'Пожалуйста, добавьте ещё '.($requirement_cars_count - $application->cars->count()).' машин']);
        }
        //Qoshimcha qulayliklar belgilanmagan bolsa statuslarni rad etish (0) ga ozgartirib chiqish
        if(!$application->daily_technical_job){
            $application->daily_technical_job_status = 0;
        }
        if(!$application->daily_medical_job){
            $application->daily_medical_job_status = 0;
        }
        if(!$application->hours_rule){
            $application->hours_rule_status = 0;
        }
        if(!$application->videoregistrator){
            $application->videoregistrator_status = 0;
        }
        if(!$application->gps){
            $application->gps_status = 0;
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
        if($car->gai == null && $car->adliya == null){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не проверено']);
        }
        if($inputs['status'] == 'accepted'){
            if($car->gai != null){
                $checked_car = [
                    'date' => $car->gai->pMadeofYear,
                    'capacity' => $car->gai->pNumberofplace,
                    'bustype' => $car->gai->pTypeOfAuto,
                ];
                if($car->date != $checked_car['date']){
                    return response()->json(['error' => true, 'message' => 'Год выпуска автомобиля не совпадает']);
                }
                // if($car->capacity != $checked_car['capacity']){
                //     return response()->json(['error' => true, 'message' => 'Вместимость автомобиля не соответствует']);
                // }
            }
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

    public function setAdditionStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required|integer',
            'target' => ['required',Rule::in(['daily_technical_job_status','daily_medical_job_status','hours_rule_status','videoregistrator_status','gps_status']),],
            'status' => ['required',Rule::in([0,1]),],
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $application = Application::find($inputs['app_id']);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        $application->{$inputs['target']} = $inputs['status'];
        $application->save();
        return response()->json(['success' => true, 'message' => 'Действие выполнено']);
    }

    public function certificates(Request $request)
    {
        $result = Certificate::with(['user','direction','car'])->orderBy('id','DESC')->paginate(12);
        return response()->json(['success' => true,'result' => $result]);
    }

    public function certificateShow(Request $request,$id)
    {
        $result = Certificate::with(['user','direction','car','contract'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Сертификат не найдено']);
        }
        return response()->json(['success' => true,'result' => $result]);
    }

    public function userCertificates(Request $request)
    {
        $user = $request->user();
        $result = Certificate::with(['user','direction','car'])
                        ->orderBy('id','DESC')
                        ->where('user_id','=',$user->id)
                        ->paginate(12);
        return response()->json(['success' => true,'result' => $result]);
    }

    public function userCertificateShow(Request $request,$id)
    {
        $user = $request->user();
        $result = Certificate::with(['user','direction','car','contract'])->where('user_id','=',$user->id)->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Сертификат не найдено']);
        }
        return response()->json(['success' => true,'result' => $result]);
    }

    public function userCars(Request $request)
    {
        $user = $request->user();
        $result = UserCar::with(['user','direction','bustype','busmodel','busmarka','tclass'])
            ->orderBy('id','DESC')
            ->where('user_id','=',$user->id)
            ->paginate(12);
        return response()->json(['success' => true,'result' => $result]);
    }

}
