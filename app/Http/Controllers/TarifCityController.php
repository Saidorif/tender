<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TarifCity;
use Validator;
use Str;

class TarifCityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role_name = $user->role->name;
        if($role_name == 'admin'){
            $result = TarifCity::with('region')->paginate(20);
        }else{
            $result = TarifCity::with('region')->where(['region_id' => $user->region_id])->paginate(20);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = TarifCity::with('region')->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = TarifCity::with('region')->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тариф не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_id'  => 'required|integer',
            'tarif'  => 'required|numeric',
            'tarif_bagaj'  => 'nullable|numeric',
            'file'  => 'required|file',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        if($user->role->name != 'admin'){
            return response()->json(['error' => true,'message' => 'You are not admin']);
        }
        $inputs = $request->all();
        //Upload file
        if($request->hasFile('file')){
            $path = public_path('tarif');
            $file = $request->file('file');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $inputs['file'] = '/tarif/'.$fileName;
        }
        $result = TarifCity::create($inputs);

        return response()->json(['success' => true, 'message' => 'Тариф успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $result = TarifCity::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тариф не найден']);
        }
        $user = $request->user();
        if($user->role->name != 'admin'){
            if($user->region_id != $result->region_id){
                return response()->json(['error' => true,'message' => 'You are not allowed']);
            }
        }
        $validator = Validator::make($request->all(), [
            'region_id'  => 'required|integer',
            'tarif'  => 'required|numeric',
            'tarif_bagaj'  => 'nullable|numeric',
            'file'  => 'nullable|file',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        //Upload file
        if($request->hasFile('file')){
            $path = public_path('tarif');
            $file = $request->file('file');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $inputs['file'] = '/audio/'.$fileName;
        }
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Тариф успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = TarifCity::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Тариф не найден']);
        }
        $user = $request->user();
        if($user->role->name != 'admin'){
            return response()->json(['error' => true,'message' => 'You are not allowed']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Тариф удален']);
    }
}

