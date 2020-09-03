<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Passport;
use App\PassportFile;
use Image;
use Storage;
use Str;

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
        // return response()->json(['error' => true, 'message' => $request->file]);

        //Upload files
        if(array_key_exists('files',$inputs)){
            foreach ($inputs['files'] as $k => $file) {
                // return response()->json(['error' => true, 'message' => $file['title']]);
                // var_dump($file);
                $input = [];
                // $strposfile = strpos($file['file'],';');
                // $subfile1 = substr($file['file'], 0,$strposfile);
                // $exfile = explode('/',$subfile1)[1];
                // $file_name = time()."file.".$exfile;

                // $document = Image::make($file['file']);
                // $file_path1 = public_path()."/passport/";
                // $document->save($file_path1.$file_name);
                // // Storage::disk('public')->put('passport/'.$passport->id, $file['file']);
                // $request->files->move(public_path('passport'), $fileName);
                $path = public_path('passport');
                $the_file = $request->file('files')[$k]['file'];
                $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
                $the_file->move($path, $fileName);
                $files[] = $fileName;
                $input['file'] = '/passport/'.$fileName;
                $input['passport_id'] = $passport->id;
                $input['title'] = $file['title'];
                $passportFile = PassportFile::create($input);
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
