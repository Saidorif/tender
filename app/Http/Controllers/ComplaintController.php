<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Complaint;
use Str;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{

    public function index()
    {
        $result = Complaint::with(['direction'])->orderBy('id', 'DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function count()
    {
        $result = Complaint::where(['status' => 'pending'])->count();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'category_id' => 'required|integer',
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
        $result = Complaint::with(['direction'])->find($id);
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
            'direction_id' => 'required|string',
            'comment' => 'required|string',
            'category_id' => 'nullable|integer',
            'status' => ['nullable',Rule::in(['active','completed']),],
            'comment_file' => 'nullable|file|mimes:jpg,jpeg,png,bmp|max:4096',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('direction_id','comment','category_id');
        // $status = 'active';
        // if(array_key_exists('status', $inputs)){
        //     if($inputs['status'] == 'completed'){
        //         $status = 'completed';
        //     }
        // }
        // $inputs['status'] = $status;
        // dd($inputs);
        if(empty($inputs['status'])){
            $inputs['status'] = 'active';
        }
        //Upload file and image
        if($request->hasFile('comment_file')){
            $input = [];
            $path = public_path('passport');
            $the_file = $request->file('comment_file');
            $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $inputs['comment_file'] = '/passport/'.$fileName;
        }
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Жалоба обновлено']);
    }


    public function destroy(Request $request, $id)
    {
        //
    }
}