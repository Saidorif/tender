<?php

namespace App\Http\Controllers;

use App\ContractCar;
use App\UserCar;
use Illuminate\Http\Request;
use Validator;
use App\Tender;
use App\Application;
use App\TenderLot;
use App\DirectionType;
use App\Direction;
use App\Reys;
use App\User;
use App\ApplicationBall;
use App\DirectionCar;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use DB;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $params = $request->all();
        //Grab user ids working in this region
        $created_by_users = User::where(['region_id' => $user->region_id])->pluck('id')->toArray();
        if($user->role->name == 'admin'){
            $builder = Tender::query()->with(['tenderlots'])->where(['status' => 'completed'])->where('time','>',now());
            if(!empty($params['region_id'])){
                $users_region = User::where(['region_id' => $params['region_id']])->pluck('id')->toArray();
                $builder->whereIn('created_by', $users_region);
            }
            if(!empty($params['time'])){
                $from_time = $params['time'].' 00:00:00';
                $to_time = $params['time'].' 23:59:59';
                $builder->whereBetween('time', [$from_time,$to_time]);
            }
            if(!empty($params['type_id'])){
                $direction_ids = Direction::where(['type_id' => $params['type_id']])->pluck('id')->toArray();
                if(empty($direction_ids)){
                    $direction_ids = [0];
                }
                $builder->whereHas('tenderlots', function ($query) use ($direction_ids) {
                    $query->whereJsonContains('direction_id', $direction_ids);
                });
            }
            $tenders = $builder->paginate(12);
        }
        else{
            // $tenders = Tender::whereIn('created_by', $created_by_users)->with(['tenderlots'])->paginate(12);
            $tenders = Tender::with(['tenderlots'])->whereNotNull('approved_by')->where('time','>',date('Y-m-d H:m:s'))->paginate(12);
        }
        return response()->json(['success' => true,'result' => $tenders]);
    }

    public function userIndex(Request $request)
    {
        $tenders = Tender::where(['status' => 'pending'])->with(['tenderlots'])->where('time','>',now())->paginate(12);
        return response()->json(['success' => true, 'result' => $tenders]);
    }

    public function userCompleted(Request $request)
    {
        $tenders = Tender::where(['status' => 'completed'])->with(['tenderlots'])->paginate(12);
        return response()->json(['success' => true, 'result' => $tenders]);
    }

    public function announceTender(Request $request)
    {
        $tenders = Tender::where(['status' => 'pending'])->with(['tenderlots'])->paginate(12);
        return response()->json(['success' => true, 'result' => $tenders]);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $builder = Direction::query();
        $builder->where('name','LIKE', '%'.$inputs['name'].'%');
        $builder->orWhere('pass_number','LIKE', '%'.$inputs['name'].'%');
        $directions = $builder->get();
        $direction_ids = $directions->pluck(['id']);

        $tenderBuilder = Tender::query();
        if(count($directions) > 0){
            $tenderBuilder->whereJsonContains('direction_ids', $direction_ids);
        }
        $tenders = $tenderBuilder->get();
        return response()->json([
            'success' => true,
            'result' => $tenders,
        ]);
    }

    public function edit($id)
    {
        $result = Tender::with(['tenderlots','createdBy','approvedBy'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $direction_ids = Direction::pluck('id');
        $validator = Validator::make($request->all(),[
            'data' => 'required|array',
            'data.*.*.direction_id' => 'required|integer',
            'data.*.*.reys_id' => 'nullable|array',
            'data.*.*.reys_id.*' => 'required|integer',
            'time' => 'required|string',
            'address' => 'required|string',
            'data.*.*.status' => ['required',Rule::in(['all','custom'])],
            'data.*.*.text' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $data = $request->input('data');
        $user = $request->user();
        $direction_ids = [];
        $tender_lots = [];
        $the_direction_err = [];
        //Check for direction busy or free
        foreach ($data as $items) {
            foreach ($items as $item) {
                $the_direction = Direction::find($item['direction_id']);
                if(!$the_direction){
                    $the_direction_err[] = 'Направление с ID = '.$item['direction_id'].' не существует';
                }
                if($the_direction->status == 'approved'){
                    $the_direction_err[] = 'Невозможно добавить... Направление уже используется - '.$the_direction->name;
                }
                if($the_direction->contract_id != null ){
                    $the_direction_err[] = 'Невозможно добавить... Направление уже используется - '.$the_direction->name;
                }
                if($the_direction->status == 'busy' || $the_direction->reys_status == 'all' ){
                    $the_direction_err[] = 'Невозможно добавить... Направление уже используется - '.$the_direction->name;
                }
                if($the_direction->reys_status == 'custom' ){
                    $tenderLot = TenderLot::whereJsonContains('reys_id',$item['reys_id'])->first();
                    if($tenderLot){
                        $the_direction_err[] = 'Направление с этими рейcами уже используется - '.$the_direction->name;
                    }
                }
                // if($the_direction->tender_id != null || $the_direction->lot_id != null ){
                //     $the_direction_err[] = 'Невозможно добавить... Направление уже используется';
                // }
                if($the_direction->type_id != 1 && $the_direction->tarif == 0){
                    $the_direction_err[] = 'Тариф направления равен нулю. Пожалуйста, заполните поле - '.$the_direction->name;
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
        }
        if(count($the_direction_err)){
            return response()->json(['error' => true, 'message' => $the_direction_err]);
        }
        $tenderTime = Carbon::parse($request->input('time'))->format('Y-m-d H:i:s');
        //Get direction_ids in to one array
        foreach ($data as $key => $d) {
            foreach ($d as $k => $value) {
                $direction_ids[] = $value['direction_id'];
                $tender_lots[$key]['direction_id'][] = $value['direction_id'];
                $tender_lots[$key]['time'] = $tenderTime;
                $tender_lots[$key]['status'] = $value['status'];
                if($value['status'] == 'custom'){
                    $direction = Direction::find($value['direction_id']);
                    $direction->reys_status = 'custom';
                    $direction->save();
                    // foreach ($value['reys_id'] as $key => $reys) {
                    //     $reys = Reys::find($reys);
                    //     $reys->status = 'pending';
                    //     $reys->save();
                    // }
                }
                if($value['status'] == 'all'){
                    $direction = Direction::find($value['direction_id']);
                    $direction->reys_status = 'all';
                    $direction->save();
                    // foreach ($direction->schedule as $key => $r) {
                    //     $r->status = 'pending';
                    //     $r->save();
                    // }
                }
                if(isset($tender_lots[$key]['reys_id'])){
                    $tender_lots[$key]['reys_id'] = array_merge($value['reys_id'],$tender_lots[$key]['reys_id']);
                }else{
                    $tender_lots[$key]['reys_id'] = $value['reys_id'];
                }
            }
        }
        $direction_ids = array_unique($direction_ids);
        $direction_ids = array_values($direction_ids);

        //Create Tender Object
        $tender = Tender::create([
            'time' => $tenderTime,
            'address' => $request->input('address'),
            'direction_ids' => $direction_ids,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        //Create tender LOTS
        foreach ($data as $key => $items) {
            $lotArr = [];
            foreach ($items as $k => $item) {
                if(isset($lotArr['reys_id'])){
                    $lotArr['reys_id'] = array_merge($item['reys_id'],$lotArr['reys_id']);
                }else{
                    $lotArr['reys_id'] = $item['reys_id'];
                }
                $lotArr['direction_id'][] = $item['direction_id'];
                $lotArr['status'] = $item['status'];
                $lotArr['time'] = $tenderTime;
                $lotArr['tender_id'] = $tender->id;
                $lotArr['text'] = $item['text'];
            }
            $lotArr['direction_id'] = array_unique($lotArr['direction_id']);
            $tenderLot = TenderLot::create([
                'tender_id' => $tender->id,
                'direction_id' => $lotArr['direction_id'],
                'time' => $tenderTime,
                'reys_id' => $lotArr['reys_id'],
                'status' => 'pending',
                'text' => $lotArr['text'],
            ]);
            //update directions statuses and add tender and lot ids
            $directions = Direction::whereIn('id',$lotArr['direction_id'])->get();
            foreach($directions as $dir){
                $dir->tender_id = $tender->id;
                $dir->lot_id = $tenderLot->id;
                $dir->save();
            }
        }

        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно создано']);
    }

    public function update(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        if($tender->status == 'approved' || $tender->status == 'completed' ){
            return response()->json(['error' => true, 'message' => 'Tender already activated']);
        }
        $validator = Validator::make($request->all(),[
            'data' => 'nullable|array',
            'data.*.*.direction_id' => 'required|integer',
            'data.*.*.reys_id' => 'nullable|array',
            'data.*.*.reys_id.*' => 'required|integer',
            'time' => 'required|string',
            'address' => 'required|string',
            'data.*.*.status' => ['required',Rule::in(['all','custom'])],
            'data.*.*.text' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('address','time');
        $data = $request->input('data');
        $user = $request->user();
        $user = $request->user();
        $direction_ids = [];
        $tender_lots = [];
        $the_direction_err = [];
        //Check for direction busy or free
        if(!empty($data) > 0){
            foreach ($data as $items) {
                foreach ($items as $item) {
                    $the_direction = Direction::find($item['direction_id']);
                    if(!$the_direction){
                        $the_direction_err[] = 'Направление с ID = '.$item['direction_id'].' не существует';
                    }
                    if($the_direction->status == 'approved'){
                        $the_direction_err[] = 'Невозможно добавить... Направление уже используется - '.$the_direction->name;
                    }
                    if($the_direction->tarif == 0){
                        $the_direction_err[] = 'Тариф направления равен нулю. Пожалуйста, заполните поле - '.$the_direction->name;
                    }
                    if(!$the_direction->requirement){
                        return response()->json(['error' => true, 'message' => 'Требование не найдено в направлении - '.$the_direction->name]);
                    }
                    if($user->role->name != 'admin'){
                        if($the_direction->region_from_id != $user->region_id || $the_direction->region_to_id != $user->region_id ){
                            $the_direction_err[] = 'Нельзя добавить ... Направление в другом регионе';
                        }
                    }
                }
            }
        }

        $tender->update($inputs);
        if(!empty($data)){
            foreach ($data as $key => $items) {
                $lotArr = [];
                foreach ($items as $k => $item) {
                    if(isset($lotArr['reys_id'])){
                        $lotArr['reys_id'] = array_merge($item['reys_id'],$lotArr['reys_id']);
                    }else{
                        $lotArr['reys_id'] = $item['reys_id'];
                    }
                    $lotArr['direction_id'][] = $item['direction_id'];
                    $lotArr['status'] = $item['status'];
                    $lotArr['time'] = $tender->time;
                    $lotArr['tender_id'] = $tender->id;
                    $lotArr['text'] = $item['text'];
                }
                $lotArr['direction_id'] = array_unique($lotArr['direction_id']);
                $tenderLot = TenderLot::create([
                    'tender_id' => $tender->id,
                    'direction_id' => $lotArr['direction_id'],
                    'time' => $tender->time,
                    'reys_id' => $lotArr['reys_id'],
                    'status' => 'pending',
                    'text' => $lotArr['text'],
                ]);
                //update directions statuses and add tender and lot ids
                $directions = Direction::whereIn('id',$lotArr['direction_id'])->get();
                foreach($directions as $dir){
                    $dir->tender_id = $tender->id;
                    $dir->lot_id = $tenderLot->id;
                    $dir->save();
                }
            }
        }
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function reject(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'message' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $user = $request->user();
        $inputs = $request->only('message');
        $inputs['status'] = 'rejected';
        $inputs['approved_by'] = $user->id;
        $tender->update($inputs);
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function complete(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }

        $user = $request->user();
        $inputs = [];
        $inputs['status'] = 'completed';
        $inputs['approved_by'] = $user->id;
        $tender->update($inputs);
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function remove(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'lot_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $inputs = $request->all();
        $tender_lots = TenderLot::where(['tender_id' => $tender->id,'id' => $inputs['lot_id']])->first();
        if(!$tender_lots){
            return response()->json(['error' => true, 'message' => 'Тендер лот не найдено']);
        }
        $d_ids = $tender_lots->getDirection();
        //update directions statuses and remove tender and lot ids
        $directions = Direction::whereIn('id',$d_ids)->get();
        foreach($directions as $dir){
            $dir->tender_id = null;
            $dir->lot_id = null;
            $dir->save();
        }

        $tender_lots->delete();
        $t_d_ids = array_diff($tender->getDirection(), $d_ids);
        $tender->direction_ids = $t_d_ids;
        $tender->save();
        return response()->json([
            'success' => true,
            't_d_ids' => $t_d_ids,
            'success' => true,
            'message' => 'OK'
        ]);
    }

    public function appBall(Request $request,$id)
    {
        $app = Application::find($id);
        if(!$app){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        $result = [];
        foreach($app->direction_ids as $key => $value){
            $direction = Direction::find($value);
            $result[$key]['name'] = $direction->name;
            //2.Tarif
            $app_tarif = (int)$app->tarif;//Taklif
            $tender_tarif = $direction->tarif; //Talab
            $tender_avto_capacity = $direction->requirement->transports_seats;//(transports_seats)Tender avto transport orindiqlar sigimi
            $yonalish = $direction->type->type;
            $tarif_foizda = round(100 - (100*$app_tarif/$tender_tarif));
            $app_tarif_ball = 0;
            //Agar taklif talabdan 21% dan yuqori bolsa
            if($tarif_foizda <= -21){
                $app_tarif_ball = 0;
            }
            //Agar taklif talabdan 11 - 20% dan yuqori bolsa
            if($tarif_foizda >= -20 && $tarif_foizda <= -11){
                $app_tarif_ball = 1;
            }
            //Agar taklif talabdan 5 - 10% dan yuqori bolsa
            if($tarif_foizda < -5 && $tarif_foizda >= -10){
                $app_tarif_ball = 2;
            }
            //Agar taklif talabga mos bolsa
            if($tarif_foizda == 0){
                $app_tarif_ball = 3;
            }
            //Agar taklif talabdan 10 - 20% dan past bolsa
            if($tarif_foizda >= 10 && $tarif_foizda <= 20){
                $app_tarif_ball = 4;
            }
            //Agar taklif talabdan 21%  va undan past bolsa
            if($tarif_foizda >= 21){
                $app_tarif_ball = 5;
            }
            //3.Avto year
            $app_avto_years = 0;
            $app_avto_capacity = 0;
            foreach($app->cars as $key => $cars){
                $app_avto_years += date('Y') - $cars->date;
                $app_avto_capacity += $cars->seat_qty;
            }
            $app_avto_total = $app_avto_years / count($app->cars);

            $app_avto_ball = 0;
            //Avto ishlab chiqarilgan yildan boshlab necha yil otgani
            if($app_avto_total >= 0 && $app_avto_total <= 2){
                $app_avto_ball = 10;
            }
            if($app_avto_total >= 3 && $app_avto_total <= 5){
                $app_avto_ball = 7;
            }
            if($app_avto_total >= 6 && $app_avto_total <= 8){
                $app_avto_ball = 6;
            }
            if($app_avto_total >= 9 && $app_avto_total <= 11){
                $app_avto_ball = 5;
            }
            if($app_avto_total >= 12 && $app_avto_total <= 14){
                $app_avto_ball = 3;
            }

            //4.Yolovchilar sigimi
            $app_avto_capacity_ball = 0;
            $app_avto_capacity_foiz = round(100 - (100 * $app_avto_capacity / $tender_avto_capacity));
            //Taklif etilgan korsatkich talabdan 11% va undan yuqori
            if($app_avto_capacity_foiz <= -11){
                $app_avto_capacity_ball = 5;
            }
            //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda yuqori
            if($app_avto_capacity_foiz <= -5 && $app_avto_capacity_foiz >= -10){
                $app_avto_capacity_ball = 4;
            }
            //Taklif etilgan korsatkich talabga mos kelsa
            if($app_avto_capacity_foiz == 0){
                $app_avto_capacity_ball = 3;
            }
            //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda past
            if($app_avto_capacity_foiz >= 5 && $app_avto_capacity_foiz <= 10){
                $app_avto_capacity_ball = 2;
            }
            //Taklif etilgan korsatkich talabdan 11% oraliqda past
            if($app_avto_capacity_foiz >= 11){
                $app_avto_capacity_ball = 1;
            }
            //5.Qatnovlar soni
            $app_qatnovlar_ball = 0;
            //Agar taklif etilgan qatnovlar soni talabga teng yoki yuqori bolsa 3 ball bomasa 0
            $tender_qatnovlar_soni = count($direction->schedule);
            if((int)$app->qty_reys >= $tender_qatnovlar_soni){
                $app_qatnovlar_ball = 3;
            }
            //6.Transport kategoriyasiga mosligi
            //7.Transport modelining mosligi
            $tender_cars = $direction->cars;
            $app_categoriya = 0;
            $app_model = 0;
            foreach ($tender_cars as $key => $t_car) {
                foreach ($app->cars as $key => $a_car) {
                    //6.Transport kategoriyasiga mosligi
                    if($t_car->bustype_id == $a_car->bustype_id){
                        $app_categoriya ++;
                    }
                    //7.Transport modelining mosligi
                    if($t_car->busmodel_id == $a_car->busmodel_id){
                        $app_model ++;
                    }
                }
            }
            //8.Qoshimcha qulayliklar mavjudligi
            $avto_qulayliklar_ball = 0;
            foreach($app->cars as $key => $car){
                if((int)$car->conditioner == 1){
                    $avto_qulayliklar_ball += 1.20;
                }
                if((int)$car->internet == 1){
                    $avto_qulayliklar_ball += 1.15;
                }
                if((int)$car->bio_toilet == 1){
                    $avto_qulayliklar_ball += 1.10;
                }
                if((int)$car->bus_adapted == 1){
                    $avto_qulayliklar_ball += 1.20;
                }
                if((int)$car->telephone_power == 1){
                    $avto_qulayliklar_ball += 1.05;
                }
                if((int)$car->monitor == 1){
                    $avto_qulayliklar_ball += 1.05;
                }
                if($car->station_announce){
                    $avto_qulayliklar_ball += 1.05;
                }
            }
            $avto_qulayliklar_ball = $avto_qulayliklar_ball / count($app->cars);
            //9.Tadbirlar rejasi
            $tadbirlar_rejasi_ball = 0;
            if((int)$app->daily_technical_job == 1){
                $tadbirlar_rejasi_ball += 1;
            }
            if((int)$app->daily_medical_job == 1){
                $tadbirlar_rejasi_ball += 1;
            }
            if((int)$app->hours_rule == 1){
                $tadbirlar_rejasi_ball += 1;
            }
            if((int)$app->videoregistrator == 1){
                $tadbirlar_rejasi_ball += 1;
            }
            if((int)$app->gps == 1){
                $tadbirlar_rejasi_ball += 1;
            }
            //10.Ustuvor mezonlar

            $result[$key]['app_tarif_ball'] = $app_tarif_ball;
            $result[$key]['app_avto_ball'] = $app_avto_ball;
            $result[$key]['app_avto_capacity_ball'] = $app_avto_capacity_ball;
            $result[$key]['app_qatnovlar_ball'] = $app_qatnovlar_ball;
            $result[$key]['app_categoriya'] = $app_categoriya;
            $result[$key]['app_model'] = $app_model;
            $result[$key]['avto_qulayliklar_ball'] = round($avto_qulayliklar_ball,3);
            $result[$key]['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;
            $result[$key]['total'] = $app_tarif_ball + $app_avto_ball + $app_avto_capacity_ball + $app_qatnovlar_ball + $app_categoriya + $app_model + round($avto_qulayliklar_ball,3) + $tadbirlar_rejasi_ball;
        }
        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function completedTenders(Request $request)
    {
        $user = $request->user();
        $params = $request->all();
        //Grab user ids working in this region
        $created_by_users = User::where(['region_id' => $user->region_id])->pluck('id')->toArray();
        $role_name = $user->role->name;
        if($role_name == 'admin'){
            if(!empty($params['region_id']) || !empty($params['time']) || !empty($params['status'])){
                $builder = Tender::query()->where('time','<', now());
                if(!empty($params['region_id'])){
                    $users_region = User::where(['region_id' => $params['region_id']])->pluck('id')->toArray();
                    $builder->whereIn('created_by', $users_region);
                }
                if(!empty($params['time'])){
                    $from_time = $params['time'].' 00:00:00';
                    $to_time = $params['time'].' 23:59:59';
                    $builder->whereBetween('time', [$from_time,$to_time]);
                }
                if(!empty($params['status']) && $params['status'] == true){
                    $builder->where('status','=','completed');
                }else{
                    $builder->where(['status' => 'completed'])->orWhere(['status' => 'approved']);
                }
                if(!empty($params['no_lots']) && $params['no_lots'] == true){
                    $tender_ids = Application::all()->pluck('tender_id')->toArray();
                    $builder->whereNotIn('id',$tender_ids);
                }
                $result = $builder->orderBy('id','DESC')->with(['tenderlots'])->withCount(['tenderlots','tenderapps'])->paginate(12);
            }else{
                $result = Tender::with(['tenderlots'])
                    //->select('tenders.*',DB::raw('count(tender_lots.id) as tenderlots_count,count(applications.id) as tenderapps_count'))
                    //->where('tenders.time','<', Carbon::now())
                    //->leftJoin('tender_lots','tenders.id','tender_lots.tender_id')
                    //->leftJoin('applications','tenders.id','applications.tender_id')
                    //->groupBy('tenders.id')
                    ->orderBy('id','DESC')
                    ->withCount(['tenderlots','tenderapps'])
                    ->paginate(12);
            }
        }
        else{
            $result = Tender::whereIn('created_by', $created_by_users)
                ->with(['tenderlots'])
                ->withCount(['tenderlots','tenderapps'])
                ->where(['status' => 'completed'])
                ->orWhere(['status' => 'approved'])
                ->where('time','<', date('Y-m-d H:m:s'))
                ->paginate(12);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function completedTendersLots(Request $request, $id,$return = false)
    {
        $tender = Tender::where(['id' => $id])
                    //->where('time','<',date('Y-m-d H:m:s'))
                    //->where(['status' => 'completed'])
                    //->orWhere(['status' => 'approved'])
                    ->first();
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        $tender_time = new Carbon($tender->time,'Asia/Tashkent');
        $now = Carbon::now('Asia/Tashkent');
        if($tender_time->gt($now)){
            return response()->json(['error' => true, 'message' => 'Tender not completed']);
        }
        $tender_lots = TenderLot::where(['tender_id' => $tender->id])->get();
        $items = [];
        foreach($tender_lots as $key => $lot){
            $result = [];
            $calculate = false;
            //$applications = $lot->apps()->where('status','=','accepted')->get();
            $applications = Application::where(['lot_id' => $lot->id])->where('status','!=','active')->get();
            $direction_ids = $lot->getDirection();
            foreach($applications as $k => $app){
                if(count($app->balls) > 0){
                    $balls = $app->balls;
                    if($lot->contract != null){
                        if($app->id == $lot->contract->app_id){
                            foreach ($balls as $ball) {
                                $ball->contract = $lot->contract;
                                $ball->status = $app->status;
                            }
                        }
                    }
                    $result['lot_items'][$key][$k] = $balls;
                    $result['lot_id'] = $lot->id;
                    continue;
                }
                else{
                    $calculate = true;
                    foreach($direction_ids as $value){
                        $appBallArray = [];
                        $direction = Direction::find($value);
                        if(!$direction->requirement){
                            return response()->json(['error' => true, 'message' => 'Требование не найдено в направлении '.$direction->name]);
                        }
                        $result['lot_items'][$key][$k]['name'] = $direction->name;
                        $result['lot_items'][$key][$k]['company_name'] = $app->user->company_name;
                        $result['lot_items'][$key][$k]['fio'] = $app->user->getFio();
                        $result['lot_items'][$key][$k]['user'] = $app->user;
                        $result['lot_id'] = $lot->id;
                        //prepare array for store
                        $appBallArray['direction_ids'] = $value;
                        $appBallArray['name'] = $direction->name;
                        $appBallArray['company_name'] = $app->user->company_name;
                        $appBallArray['user_id'] = $app->user->id;
                        $appBallArray['app_id'] = $app->id;
                        $appBallArray['lot_id'] = $lot->id;
                        //2.Tarif
                        $app_tarif = (int)$app->getTarifOfDirection($value);//Taklif
                        $appBallArray['app_tarif'] = $app_tarif;
                        //Agar shahar yonalish bolsa
                        if($direction->type_id == 1){
                            if($direction->dir_type == 'bus'){
                                $tender_tarif = (int)$direction->regionFrom->tarifcity->first()->tarif;
                            }
                            elseif($direction->dir_type == 'taxi'){
                                $tender_tarif = (int)$direction->requirement->tarif_city;
                            }
                            $tarif_foizda = round(100 - ((100*$app_tarif)/$tender_tarif));
                            $app_tarif_ball = 0;
                            //Agar taklif talabga mos bolsa
                            if($tarif_foizda <= 9 && $tarif_foizda >= 0){
                                $app_tarif_ball = 3;
                            }
                            //Agar taklif talabdan 10 - 20% dan past bolsa
                            elseif($tarif_foizda >= 10 && $tarif_foizda <= 20){
                                $app_tarif_ball = 4;
                            }
                            //Agar taklif talabdan 21%  va undan past bolsa
                            elseif($tarif_foizda >= 21){
                                $app_tarif_ball = 5;
                            }
                        }else{
                            $tender_tarif = $direction->tarif; //Talab
                            $tarif_foizda = round(100 - ((100*$app_tarif)/$tender_tarif));
                            $app_tarif_ball = 0;
                            //Agar taklif talabdan 21% dan yuqori bolsa
                            //return $tarif_foizda;die;
                            if($tarif_foizda <= -21){
                                $app_tarif_ball = 0;
                            }
                            //Agar taklif talabdan 11 - 20% dan yuqori bolsa
                            if($tarif_foizda >= -20 && $tarif_foizda <= -11){
                                $app_tarif_ball = 1;
                            }
                            //Agar taklif talabdan 5 - 10% gacha yuqori bolsa
                            if($tarif_foizda < -5 && $tarif_foizda >= -10){
                                $app_tarif_ball = 2;
                            }
                            //Agar taklif talabga mos bolsa
                            if($tarif_foizda <= 9 && $tarif_foizda >= -4){
                                $app_tarif_ball = 3;
                            }
                            //Agar taklif talabdan 10 - 20% dan past bolsa
                            if($tarif_foizda >= 10 && $tarif_foizda <= 20){
                                $app_tarif_ball = 4;
                            }
                            //Agar taklif talabdan 21%  va undan past bolsa
                            if($tarif_foizda >= 21){
                                $app_tarif_ball = 5;
                            }
                        }
                        $appBallArray['lot_tarif'] = $tender_tarif;
                        $appBallArray['tarif_ball'] = $app_tarif_ball;

                        if($direction->reys_status == 'all'){
                            $tender_avto_capacity = $direction->requirement->transports_capacity;//(transports_seats)Tender avto transport orindiqlar sigimi
                        }else{
                            $tender_avto_capacity = (int)$direction->requirement->transports_capacity / 2;
                        }
                        $yonalish = $direction->type->type;

                        //3.Avto year
                        $app_avto_capacity = 0;
                        $app_avto_total = 0;
                        $app_avto_ball = 0;
                        $app_avto_years_total = 0;
                        $app_avto_years = 0;
                        foreach($app->getCars($value) as $cars){
                            $app_avto_years = date('Y') - $cars->date;
                            $app_avto_capacity += $cars->capacity;
                            //Avto ishlab chiqarilgan yildan boshlab necha yil otgani
                            if($app_avto_years >= 0 && $app_avto_years <= 2){
                                $app_avto_ball += 10;
                            }
                            if($app_avto_years >= 3 && $app_avto_years <= 5){
                                $app_avto_ball += 7;
                            }
                            if($app_avto_years >= 6 && $app_avto_years <= 8){
                                $app_avto_ball += 6;
                            }
                            if($app_avto_years >= 9 && $app_avto_years <= 11){
                                $app_avto_ball += 5;
                            }
                            if($app_avto_years >= 12 && $app_avto_years <= 14){
                                $app_avto_ball += 3;
                            }
                            $app_avto_years_total += $app_avto_years;
                        }
                        //Umumiy ballar talabdagi avtolar soniga bolinadi
                        $talabdagi_son = (int)$direction->requirement->auto_trans_count;
                        if($app_avto_ball){
                            if($direction->reys_status == 'all'){
                                $talabdagi_son = (int)$direction->requirement->auto_trans_count;
                            }else{
                                $talabdagi_son = (int)$direction->requirement->auto_trans_count_from;
                            }
                            $app_avto_ball = $app_avto_ball / (int)$talabdagi_son;
                        }
                        $appBallArray['app_years'] = $app_avto_years_total;
                        $appBallArray['lot_years'] = (int)$talabdagi_son;
                        $appBallArray['years_ball'] = $app_avto_ball;
                        //4.Yolovchilar sigimi
                        $app_avto_capacity_ball = 0;
                        $app_avto_capacity_foiz = round(100 - (100 * $app_avto_capacity / $tender_avto_capacity));
                        //Taklif etilgan korsatkich talabdan 11% va undan yuqori
                        if($app_avto_capacity_foiz <= -11){
                            $app_avto_capacity_ball = 5;
                        }
                        //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda yuqori
                        if($app_avto_capacity_foiz <= -5 && $app_avto_capacity_foiz >= -10){
                            $app_avto_capacity_ball = 4;
                        }
                        //Taklif etilgan korsatkich talabga mos kelsa
                        if($app_avto_capacity_foiz == 0){
                            $app_avto_capacity_ball = 3;
                        }
                        //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda past
                        if($app_avto_capacity_foiz >= 5 && $app_avto_capacity_foiz <= 10){
                            $app_avto_capacity_ball = 2;
                        }
                        //Taklif etilgan korsatkich talabdan 11% oraliqda past
                        if($app_avto_capacity_foiz >= 11){
                            $app_avto_capacity_ball = 1;
                        }
                        $appBallArray['app_capacity'] = $app_avto_capacity;
                        $appBallArray['lot_capacity'] = $tender_avto_capacity;
                        $appBallArray['capacity_ball'] = $app_avto_capacity_ball;
                        //5.Qatnovlar soni
                        $app_qatnovlar_ball = 0;
                        //Agar taklif etilgan qatnovlar soni talabga teng yoki yuqori bolsa 3 ball bomasa 0
                        $tender_qatnovlar_soni = $direction->reys_status == 'custom' ? (int)$direction->requirement->reyses_from_value : count($direction->schedule);
                        if((int)$app->getQtyOfDirection($value) >= $tender_qatnovlar_soni){
                            $app_qatnovlar_ball = 3;
                        }
                        //return $app->getQtyOfDirection($value);die;
                        $appBallArray['app_reys'] = $app->getQtyOfDirection($value);
                        $appBallArray['lot_reys'] = $tender_qatnovlar_soni;
                        $appBallArray['reys_ball'] = $app_qatnovlar_ball;
                        //6.Transport kategoriyasiga mosligi
                        //7.Transport modelining mosligi
                        $tender_cars = $direction->cars;
                        $the_tender_cars = $direction->cars()->groupBy('bustype_id')->get();
                        $tender_cars_categories = array_unique($direction->cars()->pluck('bustype_id')->toArray());
                        $app_categoriya = 0;
                        $app_model = 0;
                        $m1 = false;
                        $ggg = [];
                        foreach ($the_tender_cars as $t_car) {
                            if($t_car->bustype_id == 1){
                                $m1 = true;
                            }
                            $the_bustype = $t_car->bustype_id;
                            //$the_app_dir_cars = $app->getCars($value);
                            $the_app_dir_cars = $app->cars;
                            foreach ($the_app_dir_cars as $a_car) {
                                //6.Transport kategoriyasiga mosligi 3 ball
                                if (in_array($a_car->bustype_id,$tender_cars_categories)) {
                                    //agar avtotransport qatnashchining mulki bolsa 1.15 qoshiladi
                                    if(!$m1){
                                        if ($a_car->gai) {
                                            $app_categoriya += 3.45;
                                            $ggg[] = [
                                                'ball' => 3.45,
                                                'car' => $a_car->id,
                                                'type' => 'if',
                                            ];
                                        }else {
                                            $app_categoriya += 3;
                                            $ggg[] = [
                                                'ball' => 3,
                                                'car' => $a_car->id,
                                                'type' => 'else',
                                            ];
                                        }
                                    }
                                    //7.Transport modelining mosligi
                                    foreach ($t_car->bustype->tclass as $t_class) {
                                        if($m1) {
                                            if ($t_class->id == $a_car->tclass_id) {
                                                $percent = 1;
                                                if ($a_car->gai) {
                                                    $percent = 1.15;
                                                }
                                                //А класс (матиз, дамас)
                                                if ($a_car->tclass_id == 1) {
                                                    $app_model += 2 * $percent;
                                                }
                                                //В Класс
                                                if ($a_car->tclass_id == 2) {
                                                    $app_model += 3 * $percent;
                                                }
                                                //C Класс
                                                if ($a_car->tclass_id == 3) {
                                                    $app_model += 4 * $percent;
                                                }
                                                //D Класс
                                                if ($a_car->tclass_id == 4) {
                                                    $app_model += 5 * $percent;
                                                }
                                                //M Класс
                                                if ($a_car->tclass_id == 5) {
                                                    $app_model += 4 * $percent;
                                                }
                                                //E Класс
                                                if ($a_car->tclass_id == 13) {
                                                    $app_model += 2 * $percent;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //Model mosligidan chiqqan umumiy ball jadvallar soniga bolinadi
                        $app_model = round($app_model / (int)$direction->requirement->schedules,2);
                        //6-izox: Barcha ballar qoshiladi va talab etilgan avtotransportlar soniga bolinadi

                        //return $app_categoriya;
                        $app_categoriya  = round($app_categoriya / (int)$direction->requirement->schedules,2);
                        $appBallArray['app_categories'] = array_unique($app->getCars($value)->pluck('bustype_id')->toArray());
                        $appBallArray['lot_categories'] = $tender_cars->pluck('bustype_id')->toArray();
                        $appBallArray['categories_ball'] = round($app_categoriya,2);
                        $appBallArray['app_models'] = array_unique($app->getCars($value)->pluck('tclass_id')->toArray());
                        $appBallArray['lot_models'] = $tender_cars->pluck('tclass_id')->toArray();
                        $appBallArray['models_ball'] = $app_model;
                        //8.Qoshimcha qulayliklar mavjudligi
                        $avto_qulayliklar_ball = 0;
                        $conditioner_cars = $app->cars()->where(['conditioner' => 1])->count();
                        $internet_cars = $app->cars()->where(['internet' => 1])->count();
                        $bio_toilet_cars = $app->cars()->where(['bio_toilet' => 1])->count();
                        $bus_adapted_cars = $app->cars()->where(['bus_adapted' => 1])->count();
                        $telephone_power_cars = $app->cars()->where(['telephone_power' => 1])->count();
                        $monitor_cars = $app->cars()->where(['monitor' => 1])->count();
                        $station_announce_cars = $app->cars()->where(['station_announce' => 1])->count();
                        $cars_rest_total = 0;

                        foreach($app->getCars($value) as $car){
                            if((int)$car->conditioner == 1){
                                $cars_rest_total += (3 * 1.20);
                            }
                            if((int)$car->internet == 1){
                                $cars_rest_total += (3 * 1.15);
                            }
                            if((int)$car->bio_toilet == 1){
                                $cars_rest_total += (3 * 1.10);
                            }
                            if((int)$car->bus_adapted == 1){
                                $cars_rest_total += (3 * 1.10);
                            }
                            if((int)$car->telephone_power == 1){
                                $cars_rest_total += (3 * 1.05);
                            }
                            if((int)$car->monitor == 1){
                                $cars_rest_total += (3 * 1.05);
                            }
                            if($car->station_announce){
                                $cars_rest_total += (3 * 1.05);
                            }
                        }
                        if($cars_rest_total){
                            $avto_qulayliklar_ball = $cars_rest_total / count($app->getCars($value));
                        }
                        //9.Tadbirlar rejasi
                        $appBallArray['daily_technical_job'] = 0;
                        $appBallArray['daily_medical_job'] = 0;
                        $appBallArray['hours_rule'] = 0;
                        $appBallArray['videoregistrator'] = 0;
                        $appBallArray['gps'] = 0;

                        $tadbirlar_rejasi_ball = 0;
                        if((int)$app->daily_technical_job == 1){
                            $tadbirlar_rejasi_ball += 1;
                            $appBallArray['daily_technical_job'] = (int)$app->daily_technical_job;
                        }
                        if((int)$app->daily_medical_job == 1){
                            $tadbirlar_rejasi_ball += 1;
                            $appBallArray['daily_medical_job'] = (int)$app->daily_medical_job;
                        }
                        if((int)$app->hours_rule == 1){
                            $tadbirlar_rejasi_ball += 1;
                            $appBallArray['hours_rule'] = (int)$app->hours_rule;
                        }
                        if((int)$app->videoregistrator == 1){
                            $tadbirlar_rejasi_ball += 1;
                            $appBallArray['videoregistrator'] = (int)$app->videoregistrator;
                        }
                        if((int)$app->gps == 1){
                            $tadbirlar_rejasi_ball += 1;
                            $appBallArray['gps'] = (int)$app->gps;
                        }
                        $appBallArray['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;

                        //10.Ustuvor mezonlar

                        $result['lot_items'][$key][$k]['app_avto_years'] = $app_avto_years;
                        $result['lot_items'][$key][$k]['app_tarif'] = $app_tarif;
                        $result['lot_items'][$key][$k]['tender_tarif'] = $direction->tarif;
                        $result['lot_items'][$key][$k]['tarif_foizda'] = $tarif_foizda;
                        $result['lot_items'][$key][$k]['app_tarif_ball'] = $app_tarif_ball;
                        $result['lot_items'][$key][$k]['app_avto_ball'] = $app_avto_ball;
                        $result['lot_items'][$key][$k]['app_avto_capacity_ball'] = $app_avto_capacity_ball;
                        $result['lot_items'][$key][$k]['app_qatnovlar_ball'] = $app_qatnovlar_ball;
                        $result['lot_items'][$key][$k]['app_categoriya'] = $app_categoriya;
                        $result['lot_items'][$key][$k]['app_model'] = $app_model;
                        $result['lot_items'][$key][$k]['avto_qulayliklar_ball'] = round($avto_qulayliklar_ball,3);
                        $result['lot_items'][$key][$k]['cars_rest_total'] = $cars_rest_total;
                        $result['lot_items'][$key][$k]['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;
                        if($m1){
                            $result['lot_items'][$key][$k]['total'] = $app_tarif_ball + $app_avto_ball + $app_avto_capacity_ball + $app_qatnovlar_ball + $app_model + round($avto_qulayliklar_ball,3) + $tadbirlar_rejasi_ball;
                        }else{
                            $result['lot_items'][$key][$k]['total'] = $app_tarif_ball + $app_avto_ball + $app_avto_capacity_ball + $app_qatnovlar_ball + $app_categoriya + round($avto_qulayliklar_ball,3) + $tadbirlar_rejasi_ball;
                        }
                        $appBallArray['total_ball'] = $result['lot_items'][$key][$k]['total'];
                        $appBallArray['cars_ball'] =$result['lot_items'][$key][$k]['avto_qulayliklar_ball'];
                        $result['lot_items'][$key][$k]['appBallArray'] = $appBallArray;
                        $appBallArray['details'] = $result;
                        $appBallArray['reys_status'] = $direction->reys_status;
                        $applicationBall = ApplicationBall::create($appBallArray);
                        $app->total_ball += $applicationBall->total_ball;
                        $app->save();
                    }
                }
            }
            $items[] = $result;
        }
        if($calculate){
            $items = [];
            foreach($tender_lots as $key => $lot) {
                $result = [];
                $applications = $lot->apps()->where('status', '=', 'accepted')->get();
                foreach ($applications as $k => $app) {
                    if (count($app->balls) > 0) {
                        $balls = $app->balls;
                        if ($lot->contract != null) {
                            if ($balls->app_id == $lot->contract->app_id) {
                                $balls->contract = $lot->contract;
                            }
                        }
                        $result['lot_items'][$key][$k] = $balls;
                        continue;
                    }
                }
                $items[] = $result;
            }
        }
//        if($return){
//            return $items;
//        }
        return response()->json(['success' => true, 'result' => $items,'calculate' => $calculate,'tender' => $tender]);
    }

    public function completedTendersBall(Request $request,$id,$inside = false)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        if($tender->status == 'approved'  || $tender->status == 'completed'){
            //Get applications
            $applications = Application::where(['tender_id' => $tender->id,'status' => 'approved'])->orWhere(['status' => 'accepted'])->get();
            $items = [];
            foreach($applications as $key => $app){
                $result = [];
                foreach($app->lots->getDirection() as $k => $value){
                    $direction = Direction::find($value);
                    $result[$key]['name'] = $direction->name;
                    $result[$key]['company_name'] = $app->user->company_name;
                    $result[$key]['fio'] = $app->user->getFio();
                    $result[$key]['user'] = $app->user;
                    //2.Tarif
                    $app_tarif = (int)$app->tarif;//Taklif
                    //Agar shahar yonalish bolsa
                    if($direction->type_id == 1){
                        $tender_tarif = (int)$direction->regionFrom->tarifcity->first()->tarif;
                        $tarif_foizda = round(100 - ((100*$app_tarif)/$tender_tarif));
                        $app_tarif_ball = 0;
                        //Agar taklif talabga mos bolsa
                        if($tarif_foizda <= 9){
                            $app_tarif_ball = 3;
                        }
                        //Agar taklif talabdan 10 - 20% dan past bolsa
                        if($tarif_foizda >= 10 && $tarif_foizda <= 20){
                            $app_tarif_ball = 4;
                        }
                        //Agar taklif talabdan 21%  va undan past bolsa
                        if($tarif_foizda >= 21){
                            $app_tarif_ball = 5;
                        }
                    }else{
                        $tender_tarif = $direction->tarif; //Talab
                        $tarif_foizda = round(100 - ((100*$app_tarif)/$tender_tarif));
                        $app_tarif_ball = 0;
                        //Agar taklif talabdan 21% dan yuqori bolsa
                        if($tarif_foizda <= -21){
                            $app_tarif_ball = 0;
                        }
                        //Agar taklif talabdan 11 - 20% dan yuqori bolsa
                        if($tarif_foizda >= -20 && $tarif_foizda <= -11){
                            $app_tarif_ball = 1;
                        }
                        //Agar taklif talabdan 5 - 10% gacha yuqori bolsa
                        if($tarif_foizda < -5 && $tarif_foizda >= -10){
                            $app_tarif_ball = 2;
                        }
                        //Agar taklif talabga mos bolsa
                        if($tarif_foizda <= 9){
                            $app_tarif_ball = 3;
                        }
                        //Agar taklif talabdan 10 - 20% dan past bolsa
                        if($tarif_foizda >= 10 && $tarif_foizda <= 20){
                            $app_tarif_ball = 4;
                        }
                        //Agar taklif talabdan 21%  va undan past bolsa
                        if($tarif_foizda >= 21){
                            $app_tarif_ball = 5;
                        }
                    }

                    $tender_avto_capacity = $direction->requirement->transports_seats;//(transports_seats)Tender avto transport orindiqlar sigimi
                    $yonalish = $direction->type->type;

                    //3.Avto year
                    $app_avto_capacity = 0;
                    $app_avto_total = 0;
                    $app_avto_ball = 0;
                    foreach($app->cars as $cars){
                        // $app_avto_years = 0;
                        $app_avto_years = date('Y') - $cars->date;
                        $app_avto_capacity += $cars->seat_qty;
                        //Avto ishlab chiqarilgan yildan boshlab necha yil otgani
                        if($app_avto_years >= 0 && $app_avto_years <= 2){
                            $app_avto_ball += 10;
                        }
                        if($app_avto_years >= 3 && $app_avto_years <= 5){
                            $app_avto_ball += 7;
                        }
                        if($app_avto_years >= 6 && $app_avto_years <= 8){
                            $app_avto_ball += 6;
                        }
                        if($app_avto_years >= 9 && $app_avto_years <= 11){
                            $app_avto_ball += 5;
                        }
                        if($app_avto_years >= 12 && $app_avto_years <= 14){
                            $app_avto_ball += 3;
                        }
                    }
                    //Umumiy ballar talabdagi avtolar soniga bolinadi
                    if($app_avto_ball){
                        $app_avto_ball = $app_avto_ball / (int)$direction->requirement->auto_trans_count;
                    }

                    //4.Yolovchilar sigimi
                    $app_avto_capacity_ball = 0;
                    $app_avto_capacity_foiz = round(100 - (100 * $app_avto_capacity / $tender_avto_capacity));
                    //Taklif etilgan korsatkich talabdan 11% va undan yuqori
                    if($app_avto_capacity_foiz <= -11){
                        $app_avto_capacity_ball = 5;
                    }
                    //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda yuqori
                    if($app_avto_capacity_foiz <= -5 && $app_avto_capacity_foiz >= -10){
                        $app_avto_capacity_ball = 4;
                    }
                    //Taklif etilgan korsatkich talabga mos kelsa
                    if($app_avto_capacity_foiz == 0){
                        $app_avto_capacity_ball = 3;
                    }
                    //Taklif etilgan korsatkich talabdan 5% - 10% oraliqda past
                    if($app_avto_capacity_foiz >= 5 && $app_avto_capacity_foiz <= 10){
                        $app_avto_capacity_ball = 2;
                    }
                    //Taklif etilgan korsatkich talabdan 11% oraliqda past
                    if($app_avto_capacity_foiz >= 11){
                        $app_avto_capacity_ball = 1;
                    }
                    //5.Qatnovlar soni
                    $app_qatnovlar_ball = 0;
                    //Agar taklif etilgan qatnovlar soni talabga teng yoki yuqori bolsa 3 ball bomasa 0
                    $tender_qatnovlar_soni = count($direction->schedule);
                    if((int)$app->getQtyOfDirection($value) >= $tender_qatnovlar_soni){
                        $app_qatnovlar_ball = 3;
                    }
                    //6.Transport kategoriyasiga mosligi
                    //7.Transport modelining mosligi
                    $tender_cars = $direction->cars;
                    $app_categoriya = 0;
                    $app_model = 0;
                    foreach ($tender_cars as $t_car) {
                        foreach ($app->cars as $a_car) {
                            //6.Transport kategoriyasiga mosligi 3 ball
                            if($t_car->bustype_id == $a_car->bustype_id){
                                //agar avtotransport qatnashchining mulki bolsa 1.15 qoshiladi
                                if($a_car->gai){
                                    $app_categoriya += 3.45;
                                }else{
                                    $app_categoriya += 3;
                                }
                                //7.Transport modelining mosligi
                                foreach($t_car->bustype->tclass as $t_class){
                                    if($t_class->id == $a_car->tclass_id){
                                        $percent = 1;
                                        if($a_car->gai){
                                            $percent = 1.15;
                                        }
                                        //А класс (матиз, дамас)
                                        if($a_car->tclass_id == 4){
                                            $app_model += 2 * $percent;
                                        }
                                        //В Класс
                                        if($a_car->tclass_id == 6){
                                            $app_model += 3 * $percent;
                                        }
                                        //C Класс
                                        if($a_car->tclass_id == 7){
                                            $app_model += 4 * $percent;
                                        }
                                        //D Класс
                                        if($a_car->tclass_id == 8){
                                            $app_model += 5 * $percent;
                                        }
                                        //M Класс
                                        if($a_car->tclass_id == 9){
                                            $app_model += 4 * $percent;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //Model mosligidan chiqqan umumiy ball jadvallar soniga bolinadi
                    $app_model = round($app_model / (int)$direction->requirement->schedules,2);
                    //6-izox: Barcha ballar qoshiladi va talab etilgan avtotransportlar soniga bolinadi
                    $app_categoriya  = round($app_categoriya / (int)$direction->requirement->auto_trans_count,2);
                    //8.Qoshimcha qulayliklar mavjudligi
                    $avto_qulayliklar_ball = 0;
                    $conditioner_cars = $app->cars()->where(['conditioner' => 1])->count();
                    $internet_cars = $app->cars()->where(['internet' => 1])->count();
                    $bio_toilet_cars = $app->cars()->where(['bio_toilet' => 1])->count();
                    $bus_adapted_cars = $app->cars()->where(['bus_adapted' => 1])->count();
                    $telephone_power_cars = $app->cars()->where(['telephone_power' => 1])->count();
                    $monitor_cars = $app->cars()->where(['monitor' => 1])->count();
                    $station_announce_cars = $app->cars()->where(['station_announce' => 1])->count();
                    $cars_rest_total = 0;

                    foreach($app->cars as $car){
                        if((int)$car->conditioner == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.20;
                        }
                        if((int)$car->internet == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.15;
                        }
                        if((int)$car->bio_toilet == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.10;
                        }
                        if((int)$car->bus_adapted == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.10;
                        }
                        if((int)$car->telephone_power == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.05;
                        }
                        if((int)$car->monitor == 1 && $app_categoriya >= 3){
                            $cars_rest_total += 3 * 1.05;
                        }
                        if($car->station_announce){
                            $cars_rest_total += 3 * 1.05;
                        }
                    }
                    if($cars_rest_total){
                        $avto_qulayliklar_ball = $cars_rest_total / count($app->cars);
                    }
                    //9.Tadbirlar rejasi
                    $tadbirlar_rejasi_ball = 0;
                    if((int)$app->daily_technical_job == 1){
                        $tadbirlar_rejasi_ball += 1;
                    }
                    if((int)$app->daily_medical_job == 1){
                        $tadbirlar_rejasi_ball += 1;
                    }
                    if((int)$app->hours_rule == 1){
                        $tadbirlar_rejasi_ball += 1;
                    }
                    if((int)$app->videoregistrator == 1){
                        $tadbirlar_rejasi_ball += 1;
                    }
                    if((int)$app->gps == 1){
                        $tadbirlar_rejasi_ball += 1;
                    }

                    $result[$key]['app_tarif_ball'] = $app_tarif_ball;
                    $result[$key]['app_avto_ball'] = $app_avto_ball;
                    $result[$key]['app_avto_capacity_ball'] = $app_avto_capacity_ball;
                    $result[$key]['app_qatnovlar_ball'] = $app_qatnovlar_ball;
                    $result[$key]['app_categoriya'] = $app_categoriya;
                    $result[$key]['app_model'] = $app_model;
                    $result[$key]['minimal_ball'] = $direction->requirement->minimum_bal;
                    $result[$key]['avto_qulayliklar_ball'] = round($avto_qulayliklar_ball,3);
                    $result[$key]['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;
                    $result[$key]['total'] = $app_tarif_ball + $app_avto_ball + $app_avto_capacity_ball + $app_qatnovlar_ball + $app_categoriya + $app_model + round($avto_qulayliklar_ball,3) + $tadbirlar_rejasi_ball;
                }
                $items[] = $result;
            }
            if($inside){
                return $items;
            }
            return response()->json(['success' => true, 'result' => $items]);
        }
        return response()->json(['error' => true, 'message' => 'Tender not completed or approved']);
    }

    public function checkTenders(Request $request)
    {
        $tenders = Tender::where(['status' => 'completed'])->get();
        $tenderlots = TenderLot::whereIn('tender_id',$tenders->pluck('id')->toArray())->get();
        $result = [];
        foreach($tenderlots as $lot){
            $application = Application::orderBy('total_ball','DESC')
                ->where(['lot_id' => $lot->id,'status' => 'accepted'])
                ->with(['user','tender'])->withCount(['cars'])
                ->first();
            if($application != null){
                $result[] = $application;
            }
//            $applicationBall = ApplicationBall::orderBy('total_ball','DESC')->where(['lot_id' => $lot->id,'status' => 'active'])->first();
//            if($applicationBall != null){
//                $app = Application::with(['user','tender'])->withCount(['cars'])->find($applicationBall->app_id);
//                $result[] = $app;
//            }
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function appCars(Request $request,$id)
    {
        $result = Application::with(['carsWith','user'])->orderBy('id','ASC')->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Заявка не найдена']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function userAppCars(Request $request,$id)
    {
        $result = Application::with(['userCars','user'])->orderBy('id','ASC')->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Заявка не найдена']);
        }
        $result->company_name = $result->user->company_name;
        $result->unsetRelation('user');
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function tenderLotApprove(Request $request,$id)
    {
        $application = Application::find($id);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Application not found']);
        }
        if($application->tender_status != 'active'){
            return response()->json(['error' => true, 'message' => 'Application already '.$application->tender_status]);
        }
        $result = [];
        //Get application cars
        $cars = $application->cars;
        $accepted_cars = 0;
        foreach($cars as $car){
            if($car->status == 'accepted'){
                $accepted_cars++;
            }
        }
        if($accepted_cars == count($cars)){
            $application->tender_status = 'accepted';
            $application->save();
            return response()->json(['success' => true,'message' => 'Application accepted']);
        }else{
            $application->tender_status = 'rejected';
            $application->save();
            return response()->json(['success' => true, 'message' => 'Application rejected']);
        }
        //Update application status
        // $application->status = 'approved';
        // $application->save();

        // $tender = $application->tender;
        // $tender_lots = $tender->tenderlots;
        // //Update tender status
        // $tender->status = 'approved';
        // $tender->save();
        // //Update lots status
        // foreach($tender_lots as $lot){
        //     $lot->status = 'approved';
        //     $lot->save();
        //     $directions = $lot->direction_id;
        //     foreach($directions as $dir){
        //         Direction::where(['id' => $dir->id])->update(['status' => 'approved']);
        //     }
        // }
    }

    public function getinfo(Request $request, $id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        if($tender->status != 'completed'){
            return response()->json(['error' => true, 'message' => 'Tender not completed']);
        }
        $new_result = [];
        $lots = $this->completedTendersBall($request, $id,true);
        foreach($lots as $index => $lot){
            $new_result['lots'][] = [
                'title' => $lot[$index]['name'],
                'minimal_ball' => $lot[$index]['minimal_ball'],
                'items' => $lot
            ];
        }
        $new_result['tender'] = [
            'address' => $tender->address,
            'time' => $tender->time,
            'moderator' => $tender->moderator,
            'tenderlots_count' => $tender->tenderlots->count(),
            'tenderapps' => $tender->tenderapps->count(),
        ];
        return response()->json(['success' => true, 'result' => $new_result]);
    }

    public function destroy(Request $request, $id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $tender_lots = TenderLot::where(['tender_id' => $tender->id])->get();
        if($tender_lots){
            foreach($tender_lots as $lot){
                //update directions statuses and remove tender and lot ids
                $directions = Direction::whereIn('id',$lot->getDirection())->get();
                foreach($directions as $dir){
                    $dir->tender_id = null;
                    $dir->lot_id = null;
                    $dir->save();
                }
                $lot->delete();
            }
        }
        $tender->delete();
        return response()->json(['success' => true, 'message' => 'Тендер удален']);
    }

    public function carCheck(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'auto_number' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $car = UserCar::with(['bustype','busmodel','busmarka','tclass','user','direction'])
                    ->where(['auto_number' => $inputs['auto_number']])
                    ->where(['status' => 'accepted'])
                    ->first();
        $result = [];
        if(!$car){
            $contract_car = ContractCar::with(['bustype','busmodel','busmarka','tclass','user','contract'])
                            ->where(['auto_number' => $inputs['auto_number']])
                            ->first();
            if(!$contract_car){
                return response()->json(['error' => true,'message' => 'Автомобиль не найден']);
            }
            if(!$contract_car->contract){
                return response()->json(['error' => true,'message' => 'Автомобиль не найден']);
            }
            if($contract_car->contract->status != 'completed'){
                return response()->json(['error' => true,'message' => 'Автомобиль не найден']);
            }
            if($contract_car->contract->exp_date < now()){
                return response()->json(['error' => true,'message' => 'Автомобиль не найден']);
            }
            $contract_car->user = $contract_car->user->company_name;
            $contract_car->user_id = null;
            $contract_car->unsetRelation('user');
            $contract_car->contract_number = $contract_car->contract->number;
            $contract_car->contract_date = $contract_car->contract->exp_date;
            $directions = [];
            foreach ($contract_car->contract->direction_ids as $key => $direction){
                $directions[$key]['direction_name'] = $direction->name;
                $directions[$key]['direction_number'] = $direction->pass_number;
            }
            $contract_car->unsetRelation('contract');
            $contract_car->directions = $directions;
            $result = $contract_car;
            return response()->json(['success' => true, 'result' => $result]);
        }else{
            $directions = [];
            $contract = $car->direction->contract;
            $car->contract_number = $contract->number;
            $car->contract_date = $contract->exp_date;
            $directions[0]['direction_name'] = $car->direction->name;
            $directions[0]['direction_number'] = $car->direction->pass_number;
            $car->user = $car->user->company_name;
            $car->directions = $directions;
            $car->user_id = null;
            $car->unsetRelation('user');
            $car->unsetRelation('direction');
            $result = $car;
            return response()->json(['success' => true, 'result' => $result]);
        }
        return response()->json(['error' => true, 'message' => 'Something went wrong']);
    }
}
