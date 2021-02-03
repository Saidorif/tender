<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Station;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        
        $builder = Station::query();

        if(!empty($inputs['area_id'])){
            $builder->where(['area_id' => $inputs['area_id']]);
        }
        if(!empty($inputs['station_type'])){
            $builder->where(['station_type' => $inputs['station_type']]);
        }
        if(!empty($inputs['name'])){
            $builder->where('name','LIKE', '%'.$inputs['name'].'%');
        }
        if($user->role->name == 'admin'){
            if(!empty($inputs['region_id'])){
                $builder->where(['region_id' => $inputs['region_id']]);
            }
        }else{
            $builder = Station::where(['region_id' => $user->region_id]);
        }
        $result = $builder->with(['region','area'])->orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = Station::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function regionby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|integer',
            'area_id' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $builder = Station::query()->where(['region_id' => $request->input('region_id')]);
        if($request->has('area_id') && gettype((int)$request->has('area_id') == 'integer')){
            $builder->where(['area_id' => $request->input('area_id')]);
        }
        $result = $builder->get();
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
            // 'station_type' => 'required|string',
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
            // 'station_type' => 'required|string',
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
