<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\DirectionType;

class DirectionTypeController extends Controller
{
    public function index(Request $request)
    {
        $result = DirectionType::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = DirectionType::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = DirectionType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип направления не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result = DirectionType::create($inputs);
        return response()->json(['success' => true, 'message' => 'Тип направления успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = DirectionType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип направления не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Тип направления успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = DirectionType::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тип направления не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Тип направления удален']);
    }
}
