<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusModel;
use App\BusMarka;
use Validator;
use Illuminate\Validation\Rule;

class BusModelController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $builder = BusModel::query()->with(['bustype','marka','tclass']);
        if(!empty($params['model_id'])){
            $builder->where(['id' => $params['model_id']]);
        }
        if(!empty($params['busmarka_id'])){
            $builder->where(['busmarka_id' => $params['busmarka_id']]);
        }
        if(!empty($params['bustype_id'])){
            $builder->where(['bustype_id' => $params['bustype_id']]);
        }
        if(!empty($params['tclass_id'])){
            $builder->where(['tclass_id' => $params['tclass_id']]);
        }
        $result = $builder->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = BusModel::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bustype_id' => 'nullable|integer',
            'tclass_id' => 'nullable|integer',
            'busmarka_id' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $params = $request->all();
        $builder = BusModel::query();
        if(count($params)){
            if(!empty($params['tclass_id'])){
                $builder->where(['tclass_id' => $params['tclass_id']]);
            }
            if(!empty($params['bustype_id'])){
                $builder->where(['bustype_id' => $params['bustype_id']]);
            }
            if(!empty($params['busmarka_id'])){
                $builder->where(['busmarka_id' => $params['busmarka_id']]);
            }
        }
        $result = $builder->with(['tclass','bustype','marka'])->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = BusModel::with(['bustype','tclass','marka'])->find($id);
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
            'tclass_id' => 'required|integer',
            'bustype_id' => 'required|integer',
            'busmarka_id' => 'required|integer',
            'desc' => 'nullable|string',
            'seat_from' => 'required|integer',
            // 'seat_to' => 'required|integer',
            'stay_from' => 'required|integer',
            // 'stay_to' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        // $inputs['busmarka_id'] = $inputs['busbrand_id'];
        $result = BusModel::create($inputs);
        return response()->json(['success' => true, 'message' => 'Класс транспорта успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = BusModel::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Класс транспорта не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'tclass_id' => 'required|integer',
            'bustype_id' => 'required|integer',
            'seat_from' => 'required|integer',
            'busmarka_id' => 'required|integer',
            'desc' => 'nullable|string',
            // 'seat_to' => 'required|integer',
            'stay_from' => 'required|integer',
            // 'stay_to' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        // $inputs['busmarka_id'] = $inputs['busbrand_id'];
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Класс транспорта успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = BusModel::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Класс транспорта не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Класс транспорта удален']);
    }
}
