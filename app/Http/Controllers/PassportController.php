<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Passport;
use App\PassportFile;

class PassportController extends Controller
{
    public function index(Request $request)
    {
        $result = Passport::with(['regionTo','regionFrom','areaFrom','areaTo'])->orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = Passport::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = Passport::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Паспорт не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'nullable|string',
            'region_from_id'=> 'required|integer',
            'region_to_id'  => 'required|integer',
            'area_from_id'  => 'nullable|integer',
            'area_to_id'    => 'nullable|integer',
            'files'  => 'nullable|array',
            'files.*.file'  => 'required',
            'files.*.title'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $passport = Passport::create($inputs);

        //Upload files
        if(array_key_exists('files',$inputs)){
            foreach ($inputs['files'] as $k => $file) {
                $input = [];
                $strposfile = strpos($file['file']['file'],';');
                $subfile1 = substr($file['file']['file'], 0,$strposfile);
                $exfile = explode('/',$subfile1)[1];
                $file_name = time()."file.".$exfile;

                $document = Image::make($file['file']['file']);
                $file_path1 = public_path()."/passport/";
                $document->save($file_path1.$file_name);
                $files[] = $file_name;
                $input['passport_id'] = $passport->id;
                $input['file'] = $file_name;
                $input['title'] = $file['title'];
                $reply = PassportFile::create($input);
            }
        }

        return response()->json(['success' => true, 'message' => 'Паспорт успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $result = Passport::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Паспорт не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'name'  => 'nullable|string',
            'region_from_id'  => 'required|integer',
            'region_to_id'  => 'required|integer',
            'area_from_id'  => 'nullable|integer',
            'area_to_id'  => 'nullable|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);

        return response()->json(['success' => true, 'message' => 'Паспорт успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = Passport::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Паспорт не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Паспорт удален']);
    }
}
