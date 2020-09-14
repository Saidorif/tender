<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\PassportTiming;
use Str;

class PassportTimingController extends Controller
{
    public function index(Request $request)
    {
        $result = PassportTiming::orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = PassportTiming::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = PassportTiming::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Хронометраж не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'passport_id' => 'required|string',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s',
            'start_speedometer' => 'required|integer',
            'end_speedometer' => 'required|integer',
            'distance_from_start_station' => 'required|integer',
            'distance_between_station' => 'required|integer',
            'distance_in_limited_speed' => 'required|integer',
            'spendtime_between_station' => 'required|integer',
            'spendtime_between_limited_space' => 'required|integer',
            'spendtime_to_stay_station' => 'required|integer',
            'speed_between_station' => 'required|integer',
            'speed_between_limited_space' => 'required|integer',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:jpeg,bmp,png,jpg',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $passportTiming = PassportTiming::create($inputs);

        //Upload files
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('passport');
            $the_file = $request->file('file');
            $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $files[] = $fileName;
            $input['file'] = '/passport/'.$fileName;
            $passportTiming->file = $input['file'];
            $passportTiming->save();
        }

        return response()->json(['success' => true, 'message' => 'Хронометраж успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $passportTiming = PassportTiming::find($id);
        if(!$passportTiming){
            return response()->json(['error' => true, 'message' => 'Хронометраж не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'passport_id' => 'required|string',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s',
            'start_speedometer' => 'required|integer',
            'end_speedometer' => 'required|integer',
            'distance_from_start_station' => 'required|integer',
            'distance_between_station' => 'required|integer',
            'distance_in_limited_speed' => 'required|integer',
            'spendtime_between_station' => 'required|integer',
            'spendtime_between_limited_space' => 'required|integer',
            'spendtime_to_stay_station' => 'required|integer',
            'speed_between_station' => 'required|integer',
            'speed_between_limited_space' => 'required|integer',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:jpeg,bmp,png,jpg',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $passportTiming->update($inputs);

        //Upload files
        //Upload files
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('passport');
            $the_file = $request->file('file');
            $fileName = Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $files[] = $fileName;
            $input['file'] = '/passport/'.$fileName;
            $passportTiming->file = $input['file'];
            $passportTiming->save();
        }

        return response()->json(['success' => true, 'message' => 'Хронометраж успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = PassportTiming::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Хронометраж не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Хронометраж удален']);
    }
}