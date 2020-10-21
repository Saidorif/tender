<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Application;
use App\Tender;
use App\UserCar;

class ApplicationController extends Controller
{

    public function index()
    {
        $result = Application::orderBy('id', 'DESC')->with(['user','carsWith','lots','attachment'])->paginate(12);
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
        $user = $request->user();
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
            'date' => 'required|date',
            'conditioner' => 'required|boolean',
            'internet' => 'required|boolean',
            'bio_toilet' => 'required|boolean',
            'bus_adapted' => 'required|boolean',
            'telephone_power' => 'required|boolean',
            'monitor' => 'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
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
        $validator = Validator::make($request->all(),[
            'tender_id' => 'required|integer',
            'tarif' => 'nullable|integer',
            'status' => 'nullable|string',
            'daily_technical_job' => 'nullable|boolean',
            'daily_medical_job' => 'nullable|boolean',
            'hours_rule' => 'nullable|boolean',
            'videoregistrator' => 'nullable|boolean',
            'gps' => 'nullable|boolean',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs['status'] = 'active';
        $application->update($inputs);
        return response()->json(['success' => true, 'message' => 'Заявка обновлено']);
    }


    public function destroy(Action $action)
    {
        //
    }
}