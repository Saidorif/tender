<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusModel;
use Validator;
use Illuminate\Validation\Rule;

class BusModelController extends Controller
{
    public function index(Request $request)
    {
        $result = BusModel::orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = BusModel::all();
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
        $result = $builder->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = BusModel::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Модель автобуса не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name');
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