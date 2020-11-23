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
        $tenderTime = Carbon::parse($request->input('time'))->format('Y-m-d H:i:s');
        //Get direction_ids in to one array
        foreach ($data as $key => $d) {
            foreach ($d as $k => $value) {
                $direction_ids[] = $value['direction_id'];
                $tender_lots[$key]['direction_id'][] = $value['direction_id'];
                $tender_lots[$key]['time'] = $tenderTime;
                $tender_lots[$key]['status'] = $value['status'];
                if($value['status'] == 'custom'){
                    foreach ($value['reys_id'] as $key => $reys) {
                        $reys = Reys::find($reys);
                        $reys->status = 'pending';
                        $reys->save();
                    }
                }
                if($value['status'] == 'all'){
                    $direction = Direction::find($value['direction_id']);
                    foreach ($direction->schedule as $key => $r) {
                        $r->status = 'pending';
                        $r->save();
                    }
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
        // return response()->json(['error' => true,'result' => $lotArr]);

        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно создано']);
    }

    public function update(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
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
        $inputs = $request->only('address','time');
        $data = $request->input('data');
        $user = $request->user();
        $tender->update($inputs);

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
        // if(count($inputs['reys_id']) == 0){
        //     $tender->direction_ids = [];
        //     $tender->save();

        //     $tender_lots->delete();
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'OK'
        //     ]);
        // }else{
        //     $tenderlots_reys_ids = $tender_lots->reys_id;
        //     $result = array_diff($tenderlots_reys_ids, $inputs['reys_id']);
        //     $tender_lots->reys_id = array_values($result);
        //     $tender_lots->save();
        //     return response()->json([
        //         'success' => true,
        //         'inputs' => $inputs['reys_id'],
        //         'result_array_value' => array_values($result),
        //         'result' => $result,
        //         'message' => 'OK'
        //     ]);            
        // }
    }

    public function appBall(Request $request,$id)
    {
        $app = Application::find($id);
        if(!$app){
            return response()->json(['error' => true, 'message' => 'Заявка не найдено']);
        }
        $result = [];
        //2.Tarif
        $app_tarif = (int)$app->tarif;//Taklif
        $tender_tarif = 80;//$app->tender->tarif; Talab
        $tender_avto_capacity = 15;//Tender avto transport orindiqlar sigimi
        $firstLot = $app->lots()->first();
        $yonalish = $firstLot->direction_id[0]->type->type;
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
        $tender_qatnovlar_soni = count($firstLot->direction_id[0]->schedule);
        if((int)$app->qty_reys >= $tender_qatnovlar_soni){
            $app_qatnovlar_ball = 3;
        }
        //6.Transport kategoriyasiga mosligi
        $tender_cars = $firstLot->direction_id[0]->cars;
        $app_categoriya = 0;
        foreach ($tender_cars as $key => $t_car) {
            foreach ($app->cars as $key => $a_car) {
                if($t_car->bustype_id == $a_car->bustype_id){
                    $app_categoriya ++;
                }
            }
        }
        //7.Transport modelining mosligi
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

        $result['app_tarif_ball'] = $app_tarif_ball;
        $result['app_avto_ball'] = $app_avto_ball;
        $result['app_avto_capacity_ball'] = $app_avto_capacity_ball;
        $result['app_qatnovlar_ball'] = $app_qatnovlar_ball;
        $result['app_categoriya'] = $app_categoriya;
        $result['avto_qulayliklar_ball'] = round($avto_qulayliklar_ball,3);
        $result['tadbirlar_rejasi_ball'] = $tadbirlar_rejasi_ball;
        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    }
}
