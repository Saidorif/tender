<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Application;
use App\UserCar;

class ApplicationController extends Controller
{

    public function index()
    {
        $result = Application::orderBy('id', 'DESC')->with(['user'])->paginate(12);
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

    public function carStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'auto_number' => 'required|string',
            'direction_id' => 'required|integer',
            'tender_id' => 'required|integer',
            'bustype_id' => 'required|string',
            'busmodel_id' => 'required|string',
            'tclass_id' => 'required|string',
            'qty_reys' => 'required|string',
            'capacity' => 'required|string',
            'seat_qty' => 'required|string',
            'date' => 'required|string',
            'conditioner' => 'required|string',
            'internet' => 'required|string',
            'bio_toilet' => 'required|string',
            'bus_adapted' => 'required|string',
            'telephone_power' => 'required|string',
            'monitor' => 'required|string',
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
            'message' => 'Заявка создано'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $application = Application::with(['user','carsWith'])->find($id);
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
            'direction_id' => 'nullable|integer',
            'tarif' => 'nullable|integer',
            'status' => 'nullable|string',
            'daily_technical_job' => 'nullable|string',
            'daily_medical_job' => 'nullable|string',
            '30_hours_rule' => 'nullable|string',
            'videoregistrator' => 'nullable|string',
            'gps' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $application->update($inputs);
        return response()->json(['success' => true, 'message' => 'Заявка обновлено']);
    }


    public function destroy(Action $action)
    {
        //
    }
}