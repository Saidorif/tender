<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\PassportTiming;
use Str;
use Carbon\Carbon;

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
            'timing' => 'required|array',
            'timing.*.direction_id' => 'required|integer',
            'timing.*.region_from_id' => 'required|integer',
            'timing.*.region_to_id' => 'required|integer',
            'timing.*.area_from_id' => 'nullable|integer',
            'timing.*.area_to_id' => 'nullable|integer',
            'timing.*.station_from_id' => 'nullable|integer',
            'timing.*.station_to_id' => 'nullable|integer',
            'timing.*.start_time' => 'required|string',
            'timing.*.end_time' => 'required|string',
            'timing.*.start_speedometer' => 'required|integer',
            'timing.*.end_speedometer' => 'required|integer',
            'timing.*.distance_from_start_station' => 'required|integer',
            'timing.*.distance_between_station' => 'required|integer',
            'timing.*.distance_in_limited_speed' => 'required|integer',
            'timing.*.spendtime_between_station' => 'required|integer',
            'timing.*.spendtime_between_limited_space' => 'required|integer',
            'timing.*.spendtime_to_stay_station' => 'required|integer',
            'timing.*.speed_between_station' => 'required|integer',
            'timing.*.speed_between_limited_space' => 'required|integer',
            'timing.*.details' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->input('timing');
        foreach ($inputs as $key => $value) {
            $value['start_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $value['start_time'])->format('Y-m-d H:i:s');
            $value['end_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $value['end_time'])->format('Y-m-d H:i:s');
            $passportTiming = PassportTiming::create($value);
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
            'timing' => 'required|array',
            'timing.*.direction_id' => 'required|integer',
            'timing.*.region_from_id' => 'required|integer',
            'timing.*.region_to_id' => 'required|integer',
            'timing.*.area_from_id' => 'nullable|integer',
            'timing.*.area_to_id' => 'nullable|integer',
            'timing.*.station_from_id' => 'nullable|integer',
            'timing.*.station_to_id' => 'nullable|integer',
            'timing.*.start_time' => 'required|date_format:Y-m-d H:i:s',
            'timing.*.end_time' => 'required|date_format:Y-m-d H:i:s',
            'timing.*.start_speedometer' => 'required|integer',
            'timing.*.end_speedometer' => 'required|integer',
            'timing.*.distance_from_start_station' => 'required|integer',
            'timing.*.distance_between_station' => 'required|integer',
            'timing.*.distance_in_limited_speed' => 'required|integer',
            'timing.*.spendtime_between_station' => 'required|integer',
            'timing.*.spendtime_between_limited_space' => 'required|integer',
            'timing.*.spendtime_to_stay_station' => 'required|integer',
            'timing.*.speed_between_station' => 'required|integer',
            'timing.*.speed_between_limited_space' => 'required|integer',
            'timing.*.details' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->input('timing');
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