<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\ComplaintCategory;

class ComplaintCategoryController extends Controller
{

    public function index()
    {
        $result = ComplaintCategory::orderBy('id', 'DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $controller = ComplaintCategory::create($inputs);
        return response()->json(['success' => true, 'message' => 'Категория жалобы создано']);
    }

    public function edit(Request $request, $id)
    {
        $cCategory = ComplaintCategory::find($id);
        if(!$cCategory){
            return response()->json(['error' => true, 'message' => 'Категория жалобы не найдено']);
        }
        return response()->json(['success' => true, 'result' => $cCategory]);
    }

    public function update(Request $request, $id)
    {
        $cCategory = ComplaintCategory::find($id);
        if(!$cCategory){
            return response()->json(['error' => true, 'message' => 'Категория жалобы не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $cCategory->update($inputs);
        return response()->json(['success' => true, 'message' => 'Категория жалобы обновлено']);
    }


    public function destroy(Request $request,$id)
    {
        $cCategory = ComplaintCategory::find($id);
        if(!$cCategory){
            return response()->json(['error' => true, 'message' => 'Категория жалобы не найдено']);
        }
        $cCategory->delete();
        return response()->json(['success' => true, 'message' => 'Категория жалобы удалено']);
    }
}