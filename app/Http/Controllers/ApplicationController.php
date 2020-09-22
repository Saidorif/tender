<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Application;

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
            'auto_number' => 'required|string',
            'bustype_id' => 'required|integer',
            'busmodel_id' => 'required|integer',
            'tclass_id' => 'required|integer',
            'seat_from' => 'required|integer',
            'stay_count' => 'required|integer',
            'tarif' => 'required|integer',
            'estimated_time' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $controller = Application::create($inputs);
        return response()->json(['success' => true, 'message' => 'Действие создано']);
    }


    public function show(Action $action)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        $action = Application::where(['id' => $id])->with('controller')->first();
        if(!$action){
            return response()->json(['error' => true, 'message' => 'Действие не найдено']);
        }
        return response()->json(['success' => true, 'result' => $action]);
    }


    public function update(Request $request, $id)
    {
        $action = Application::find($id);
        if(!$action){
            return response()->json(['error' => true, 'message' => 'Действие не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'conts_id' => 'required|integer',
            'code' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $action->update($inputs);
        return response()->json(['success' => true, 'message' => 'Действие обновлено']);
    }


    public function destroy(Action $action)
    {
        //
    }
}