<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\SchemaDetail;
use App\Direction;

class SchemaDetailController extends Controller
{
    public function index(Request $request)
    {
        $result = SchemaDetail::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = SchemaDetail::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = SchemaDetail::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Детали схемы не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request, $id)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'data.*.organ' => 'required|string',
            'data.*.job' => 'required|string',
            'data.*.fio' => 'required|string',
            'data.*.date' => 'required|string',
            'data.*.direction_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найдено']);
        }
        $old_schema_details = $direction->schemaDetails;
        foreach ($old_schema_details as $key => $item) {
            $item->delete();
        }
        $inputs = $request->input('data');
        foreach ($inputs as $key => $value) {
            $result = SchemaDetail::create($value);
        }
        return response()->json(['success' => true, 'message' => 'Детали схемы успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = SchemaDetail::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Детали схемы не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'data.*.organ' => 'required|string',
            'data.*.job' => 'required|string',
            'data.*.fio' => 'required|string',
            'data.*.date' => 'required|string',
            'data.*.direction_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Детали схемы успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = SchemaDetail::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Детали схемы не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Детали схемы удален']);
    }
}
