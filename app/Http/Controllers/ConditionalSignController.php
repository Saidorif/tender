<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConditionalSign;
use Validator;

class ConditionalSignController extends Controller
{
    public function index(Request $request)
    {
        $result = ConditionalSign::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = ConditionalSign::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = ConditionalSign::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Устовный символ не найден']);
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
        $result = ConditionalSign::create($inputs);

        return response()->json(['success' => true, 'message' => 'Устовный символ успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $result = ConditionalSign::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Устовный символ не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('name');
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Устовный символ успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = ConditionalSign::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Устовный символ не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Устовный символ удален']);
    }
}
