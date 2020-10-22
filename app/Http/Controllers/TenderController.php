<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Tender;
use App\Application;
use App\TenderLot;
use App\DirectionType;
use App\Direction;
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
        $firstLot = $app->lots()->first();
        $yonalish = $firstLot->direction_id[0]->type->type;
        $tarif_foizda = round(100 - (100*$app_tarif/$tender_tarif));
        $app_tarif_ball = 0;
        //Agar taklif talabdan 21% dan yuqori bolsa
        if($tarif_foizda <= -21){
            $app_tarif_ball = 0;
            // die('Agar taklif talabdan 21% dan yuqori bolsa');
        }
        //Agar taklif talabdan 11 - 20% dan yuqori bolsa
        if($tarif_foizda >= -20 && $tarif_foizda <= -11){
            $app_tarif_ball = 1;
            // die('Agar taklif talabdan 11 - 20% dan yuqori bolsa');
        }
        //Agar taklif talabdan 5 - 10% dan yuqori bolsa
        if($tarif_foizda < -5 && $tarif_foizda >= -10){
            $app_tarif_ball = 2;
            // die('Agar taklif talabdan 5 - 10% dan yuqori bolsa');
        }
        //Agar taklif talabga mos bolsa
        if($tarif_foizda == 0){
            $app_tarif_ball = 3;
            // die('Agar taklif talabga mos bolsa');
        }
        //Agar taklif talabdan 10 - 20% dan past bolsa
        if($tarif_foizda >= 10 && $tarif_foizda <= 20){
            $app_tarif_ball = 4;
            // die('Agar taklif talabdan 10 - 20% dan past bolsa');
        }
        //Agar taklif talabdan 21%  va undan past bolsa
        if($tarif_foizda >= 21){
            $app_tarif_ball = 5;
            // die('Agar taklif talabdan 21%  va undan past bolsa');
        }
        //3.Avto year
        $app->cars;
        //4.Yolovchilar sigimi
        //5.Qatnovlar soni
        //6.Transport kategoriyasiga mosligi
        //7.Transport modelining mosligi
        //8.Qoshimcha qulayliklar mavjudligi
        //9.Tadbirlar rejasi
        //10.Ustuvor mezonlar
        //97 100-80-20

        $result['app_tarif'] = $app_tarif;
        $result['tender_tarif'] = $tender_tarif;
        return response()->json([
            'success' => true,
            'app_tarif' => $app_tarif,
            'tender_tarif' => $tender_tarif,
            'yonalish' => $yonalish,
            'tarif_foizda' => $tarif_foizda,
            'app_tarif_ball' => $app_tarif_ball,
            'result' => $result
        ]);
    }
}
