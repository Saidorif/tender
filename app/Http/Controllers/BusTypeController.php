<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\BusType;

class BusTypeController extends Controller
{
    public function index(Request $request)
    {
        $result = BusType::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = BusType::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = BusType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип автобуса не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result = BusType::create($inputs);
        return response()->json(['success' => true, 'message' => 'Тип автобуса успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = BusType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип автобуса не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Тип автобуса успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = BusType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип автобуса не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Тип автобуса удален']);
    }
}
