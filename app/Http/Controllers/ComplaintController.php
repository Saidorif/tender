<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Complaint;
use Str;

class ComplaintController extends Controller
{

    public function index()
    {
        $result = Complaint::orderBy('id', 'DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'surname' => 'required|string',
            'middlename' => 'nullable|string',
            'phone' => 'required|string',
            'text' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,bmp|max:4096',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs['status'] = 'pending';
        //Upload file and image
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('passport');
            $the_file = $request->file('file');
            $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $inputs['file'] = '/passport/'.$fileName;
        }
        $result = Complaint::create($inputs);
        return response()->json(['success' => true, 'message' => 'Ваша жалоба принята. Спасибо']);
    }


    public function edit(Request $request, $id)
    {
        $result = Complaint::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Жалоба не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }


    public function update(Request $request, $id)
    {
        $result = Complaint::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Жалоба не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'surname' => 'required|string',
            'middlename' => 'nullable|string',
            'phone' => 'required|string',
            'text' => 'required|string',
            'status' => 'nullable|string',
            'direction_id' => 'nullable|string',
            'region_id' => 'nullable|string',
            'area_id' => 'nullable|string',
            'user_id' => 'nullable|string',
            'category_id' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,bmp|max:4096',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs['status'] = 'pending';
        //Upload file and image
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('passport');
            $the_file = $request->file('file');
            $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $inputs['file'] = '/passport/'.$fileName;
        }
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Жалоба обновлено']);
    }


    public function destroy(Request $request, $id)
    {
        //
    }
}