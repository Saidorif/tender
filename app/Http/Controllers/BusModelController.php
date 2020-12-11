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
        $result = BusModel::with(['marka'])->orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = BusModel::with(['marka'])->get();
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function getByMarkaId(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'busbrand_id'  => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('busbrand_id');
        $result = BusModel::with(['marka'])->find($inputs['busbrand_id']);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $builder = BusModel::query();
        $builder->where('name','LIKE', '%'.$request->input('name').'%');
        $result = $builder->with(['marka'])->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = BusModel::with(['marka'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Модель автобуса не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'busbrand_id'  => 'required|integer',
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name','busbrand_id');
        $BusMarka = BusMarka::find($inputs['busbrand_id']);
        if(!$BusMarka){
            return response()->json(['error' => true, 'message' => 'BusMarka not found']);
        }
        $result = BusModel::create($inputs);

        return response()->json(['success' => true, 'message' => 'Модель автобуса успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $result = BusModel::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Модель автобуса не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name');
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Модель автобуса успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = BusModel::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Модель автобуса не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Модель автобуса удален']);
    }
}