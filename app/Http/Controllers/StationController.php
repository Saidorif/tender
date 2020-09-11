<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Station;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $result = Station::with(['region','area'])->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = Station::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = Station::with(['region','area'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Станция не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'region_id' => 'required|integer',
            'area_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result = Station::create($inputs);
        return response()->json(['success' => true, 'message' => 'Станция успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = Station::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Станция не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'region_id' => 'required|integer',
            'area_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Станция успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = Station::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Станция не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Станция удален']);
    }
}
