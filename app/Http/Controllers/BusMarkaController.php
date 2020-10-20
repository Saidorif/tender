<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\BusMarka;
use Illuminate\Validation\Rule;

class BusMarkaController extends Controller
{
    public function index(Request $request)
    {
        $result = BusMarka::orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = BusMarka::all();
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
        $builder = BusMarka::query();
        $builder->where('name','LIKE', '%'.$request->input('name').'%');
        $result = $builder->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = BusMarka::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Марка автобуса не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string|unique:bus_markas,name',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name');
        $result = BusMarka::create($inputs);

        return response()->json(['success' => true, 'message' => 'Марка автобуса успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $result = BusMarka::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Марка автобуса не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string|unique:bus_markas,name,'.$result->id,
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name');
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Марка автобуса успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = BusMarka::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Марка автобуса не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Марка автобуса удален']);
    }
}
