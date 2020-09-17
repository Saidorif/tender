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
        // return response()->json(['result' => $request->all()]);
        $validator = Validator::make($request->all(), [            
            'timing' => 'required|array',
            'timing.*.direction_id' => 'required|integer',
            'timing.*.region_from_id' => 'required|array',
            'timing.*.region_from_id.id' => 'required|integer',
            'timing.*.region_to_id' => 'required|array',
            'timing.*.region_to_id.id' => 'required|integer',
            'timing.*.area_from_id' => 'nullable|array',
            'timing.*.area_from_id.id' => 'required',
            'timing.*.area_to_id' => 'nullable|array',
            'timing.*.area_to_id.id' => 'nullable|integer',
            'timing.*.station_from_id' => 'nullable',
            'timing.*.station_to_id' => 'nullable|array',
            'timing.*.station_to_id.id' => 'nullable|integer',
            'timing.*.start_time' => 'required|string',
            'timing.*.end_time' => 'required|string',
            'timing.*.start_speedometer' => 'required',
            'timing.*.end_speedometer' => 'required',
            'timing.*.distance_from_start_station' => 'required',
            'timing.*.distance_between_station' => 'required',
            'timing.*.distance_in_limited_speed' => 'required',
            'timing.*.spendtime_between_station' => 'required',
            'timing.*.spendtime_between_limited_space' => 'required',
            'timing.*.spendtime_to_stay_station' => 'required',
            'timing.*.speed_between_station' => 'required',
            'timing.*.speed_between_limited_space' => 'required',
            'timing.*.details' => 'required',
            'timing.*.whereForm' => 'required',
            'timing.*.whereTo' => 'required',
            // 'timing.*.timingDetails' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->input('timing');
        foreach ($inputs as $key => $value) {
            // unset($value['areaTo']);
            // unset($value['stationTo']);
            // unset($value['areaFrom']);
            // unset($value['stationFrom']);
            // return response()->json(['result' => $value]);
            // var_dump($value);die;
            $passportTiming = PassportTiming::create([
                'direction_id' => $value['direction_id'],
                'start_time' => Carbon::parse($value['start_time'])->format('Y-m-d H:i:s'),
                'start_time' => Carbon::parse($value['start_time'])->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($value['end_time'])->format('Y-m-d H:i:s'),
                'region_from_id' => $value['region_from_id']['id'],
                'region_to_id' => $value['region_to_id']['id'],
                'detailsOptions' => json_encode($value['detailsOptions']),
                'area_from_id' => $value['area_from_id']['id'],
                'area_to_id' => $value['area_to_id']['id'],
                'station_to_id' => $value['station_to_id']['id'],
                'details' => json_encode($value['details']),
                'whereForm' => json_encode($value['whereForm']),
                'whereTo' => json_encode($value['whereTo']),
                'distance_from_start_station' => (int) $value['distance_from_start_station'],
                'distance_between_station' => (int) $value['distance_between_station'],
                'distance_in_limited_speed' => (int) $value['distance_in_limited_speed'],
                'spendtime_between_station' => (int) $value['spendtime_between_station'],
                'spendtime_between_limited_space' => (int) $value['spendtime_between_limited_space'],
                'spendtime_to_stay_station' => (int) $value['spendtime_to_stay_station'],
                'speed_between_station' => (int) $value['speed_between_station'],
                'speed_between_limited_space' => (int) $value['speed_between_limited_space'],
                'end_speedometer' => (int) $value['end_speedometer'],
                'start_speedometer' => (int) $value['start_speedometer'],
            ]);
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
            'timing.*.distance_from_start_station' => 'required',
            'timing.*.distance_between_station' => 'required',
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