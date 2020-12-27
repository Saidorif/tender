<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Tender;
use App\Application;
use App\TenderLot;
use App\DirectionType;
use App\Direction;
use App\Reys;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with(['tenderlots'])->paginate(12);
        return response()->json(['success' => true,'result' => $tenders]);
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
                    $the_direction_err[] = 'Direction with ID = '.$item['direction_id'].' does no exist';
                }
                if($the_direction->status == 'approved'){
                    $the_direction_err[] = 'Can not add... Direction already in use';
                }
            }
        }
        if(count($the_direction_err)){
            return response()->json(['error' => true, 'message' => $the_direction_err]);
        }
        return $data;
        $tenderTime = Carbon::parse($request->input('time'))->format('Y-m-d H:i:s');
        //Get direction_ids in to one array
        foreach ($data as $key => $d) {
            foreach ($d as $k => $value) {
                $direction_ids[] = $value['direction_id'];
                $tender_lots[$key]['direction_id'][] = $value['direction_id'];
                $tender_lots[$key]['time'] = $tenderTime;
                $tender_lots[$key]['status'] = $value['status'];
                if($value['status'] == 'custom'){
                    // foreach ($value['reys_id'] as $key => $reys) {
                    //     $reys = Reys::find($reys);
                    //     $reys->status = 'pending';
                    //     $reys->save();
                    // }
                }
                if($value['status'] == 'all'){
                    $direction = Direction::find($value['direction_id']);
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
            }
            $lotArr['direction_id'] = array_unique($lotArr['direction_id']);
            $tenderLot = TenderLot::create([
                'tender_id' => $tender->id,
                'direction_id' => $lotArr['direction_id'],
                'time' => $tenderTime,
                'reys_id' => $lotArr['reys_id'],
                'status' => 'pending',
            ]);
        }

        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно создано']);
    }

    public function update(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'data' => 'nullable|array',
            'data.*.*.direction_id' => 'required|integer',
            'data.*.*.reys_id' => 'nullable|array',
            'data.*.*.reys_id.*' => 'required|integer',
            'time' => 'required|string',
            'address' => 'required|string',
            'data.*.*.status' => ['required',Rule::in(['all','custom'])],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('address','time');
        $data = $request->input('data');
        $user = $request->user();
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
                }
                $lotArr['direction_id'] = array_unique($lotArr['direction_id']);
                $tenderLot = TenderLot::create([
                    'tender_id' => $tender->id,
                    'direction_id' => $lotArr['direction_id'],
                    'time' => $tender->time,
                    'reys_id' => $lotArr['reys_id'],
                    'status' => 'pending',
                ]);
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

    public function completedTenders()
    {
        $result = Tender::withCount(['tenderlots','tenderapps'])->where(['status' => 'completed'])->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function completedTendersLots(Request $request, $id)
    {
        $tender = Tender::where(['status' => 'completed'])->find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        $tender_lots = TenderLot::where(['tender_id' => $tender->id])->get();
        $items = [];
        foreach($tender_lots as $key => $lot){
            $result = [];
            $applications = $lot->apps;
            $direction_ids = $lot->getDirection();
            foreach($applications as $k => $app){
                foreach($direction_ids as $value){
                    $direction = Direction::find($value);
                    $result[$key][$k]['name'] = $direction->name;
                    $result[$key][$k]['company_name'] = $app->user->company_name;
                    $result[$key][$k]['fio'] = $app->user->getFio();
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
                    foreach($app->cars as $cars){
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
                    foreach ($tender_cars as $t_car) {
                        foreach ($app->cars as $a_car) {
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
                    foreach($app->cars as $car){
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
            
                    $result[$key][$k]['app_tarif_ball'] = $app_tarif_ball;
                    $result[$key][$k]['app_avto_ball'] = $app_avto_ball;
                    $result[$key][$k]['app_avto_capacity_ball'] = $app_avto_capacity_ball;
                    $result[$key][$k]['app_qatnovlar_ball'] = $app_qatnovlar_ball;
                    $result[$key][$k]['app_categoriya'] = $app_categoriya;
                    $result[$key][$k]['app_model'] = $app_model;
                    $result[$key][$k]['avto_qulayliklar_ball'] = round($avto_qulayliklar_ball,3);
                    $result[$key][$k]['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;
                    $result[$key][$k]['total'] = $app_tarif_ball + $app_avto_ball + $app_avto_capacity_ball + $app_qatnovlar_ball + $app_categoriya + $app_model + round($avto_qulayliklar_ball,3) + $tadbirlar_rejasi_ball;
                }
            }
            $items[] = $result;
        }
        return response()->json(['success' => true, 'result' => $items]);
    }
    
    public function completedTendersBall(Request $request,$id,$inside = false)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        if($tender->status == 'approved'  || $tender->status == 'completed'){
            //Get applications
            $applications = Application::where(['tender_id' => $tender->id,'status' => 'approved'])->orWhere(['status' => 'accpeted'])->get();
            $items = [];
            foreach($applications as $key => $app){
                $result = [];
                foreach($app->direction_ids as $k => $value){
                    $direction = Direction::find($value);
                    $result[$key]['name'] = $direction->name;
                    $result[$key]['company_name'] = $app->user->company_name;
                    $result[$key]['fio'] = $app->user->getFio();
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
        $result = Application::with(['user'])->withCount(['cars'])->where(['status' => 'accepted'])->get();
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function appCars(Request $request,$id)
    {
        $result = Application::with(['carsWith','user'])->orderBy('id','ASC')->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Application not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function tenderLotApprove(Request $request,$id)
    {
        $application = Application::orderBy('id','ASC')->find($id);
        if(!$application){
            return response()->json(['error' => true, 'message' => 'Application not found']);
        }
        $result = [];
        //Update application status
        $application->status = 'approved';
        $application->save();

        $tender = $application->tender;
        $tender_lots = $tender->tenderlots;
        //Update tender status
        $tender->status = 'approved';
        $tender->save();
        //Update lots status
        foreach($tender_lots as $lot){
            $lot->status = 'approved';
            $lot->save();
            $directions = $lot->direction_id;
            foreach($directions as $dir){
                Direction::where(['id' => $dir->id])->update(['status' => 'approved']);
            }
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function getinfo(Request $request, $id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Tender not found']);
        }
        if($tender->status != 'approved'){
            return response()->json(['error' => true, 'message' => 'Tender not approved']);
        }
        $result['lots'] = $this->completedTendersBall($request, $id,true);
        $result['tender'] = $tender->withCount('tenderlots')->get();
        return response()->json(['success' => true, 'result' => $result]);
    }
}
