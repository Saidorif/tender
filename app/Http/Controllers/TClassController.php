<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\TClass;

class TClassController extends Controller
{
    public function index(Request $request)
    {
        $result = TClass::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = TClass::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = TClass::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Класс транспорта не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'seat_from' => 'required|integer',
            'seat_to' => 'required|integer',
            'stay_from' => 'required|integer',
            'stay_to' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result = TClass::create($inputs);
        return response()->json(['success' => true, 'message' => 'Класс транспорта успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = TClass::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Класс транспорта не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'seat_from' => 'required|integer',
            'seat_to' => 'required|integer',
            'stay_from' => 'required|integer',
            'stay_to' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Класс транспорта успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = TClass::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Класс транспорта не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Класс транспорта удален']);
    }
}