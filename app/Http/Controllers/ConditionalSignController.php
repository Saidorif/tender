<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConditionalSign;
use Validator;
use Image;
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
            'name'      => 'required|string|unique:conditional_signs,name'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        //Upload file and image
        if($request->photo){
            $strpos = strpos($request->photo,';');
            $sub = substr($request->photo, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time()."photo.".$ex;

            $img = Image::make($request->photo);
            $img_path = public_path()."/signs/";
            $img->save($img_path.$img_name);
            $inputs['photo'] = $img_name;
        }
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
            'name'  => 'required|string|unique:conditional_signs,name,'.$result->id
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        // Upload file and image
        if ($request->photo != $result->photo){
            $strpos = strpos($request->photo,';');
            $sub = substr($request->photo, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time()."photo.".$ex;
            $img = Image::make($request->photo);
            $img_path = public_path()."/signs/";
            $img->save($img_path.$name);
            $image = $img_path.$result->photo;
            if (file_exists($image)){
                @unlink($image);
            }
        }
        else{
            $name = $result->photo;
        }
        $inputs = $request->all();
        $inputs['photo'] = $name;
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Устовный символ успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = ConditionalSign::find($id);
        $img_path = public_path()."/signs/";
        $image = $img_path.$result->photo;
        if (file_exists($image)){
            @unlink($image);
        }
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Устовный символ не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Устовный символ удален']);
    }
}
