<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\PassportTiming;
use App\TimingDetails;
use App\Direction;
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

    public function store(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }

        $validator = Validator::make($request->all(), [
            'timing' => 'required|array',
            'timing.*.direction_id' => 'required|integer',
            'timing.*.region_from_id' => 'required|array',
            'timing.*.region_from_id.id' => 'required|integer',
            'timing.*.region_to_id' => 'required|array',
            'timing.*.region_to_id.id' => 'required|integer',
            'timing.*.area_from_id' => 'nullable|array',
            'timing.*.area_from_id.id' => 'nullable',
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
            'timingDetails' => 'required|array',
            'technic_speed' => 'required|string',
            'traffic_speed' => 'required|string',
            'timingDetails.date' => 'required|string',
            'timingDetails.avto_number' => 'required|string',
            'timingDetails.avto_model' => 'required|string',
            'timingDetails.conclusion' => 'required|string',
            'timingDetails.persons' => 'required|array',
            'timingDetails.persons.*.name' => 'required|string',
            'timingDetails.persons.*.surname' => 'required|string',
            'timingDetails.persons.*.middlename' => 'required|string',
            'timingDetails.persons.*.job' => 'required|string',
            'timingDetails.persons.*.position' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        //Get old timings and delete
        $dTiming = $direction->timing;
        foreach ($dTiming as $key => $item) {
            $item->delete();
        }
        //Get timing details and delete
        $dTimingDetails = $direction->timingDetails;
        foreach ($dTimingDetails as $key => $details) {
            $details->delete();
        }
        $inputs = $request->input('timing');
        foreach ($inputs as $key => $value) {
            $passportTiming = PassportTiming::create([
                'direction_id' => $direction->id,
                'start_time' => Carbon::parse($value['start_time'])->format('Y-m-d H:i:s'),
                'start_time' => Carbon::parse($value['start_time'])->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($value['end_time'])->format('Y-m-d H:i:s'),
                'region_from_id' => $value['region_from_id']['id'],
                'region_to_id' => $value['region_to_id']['id'],
                // 'detailsOptions' => $value['detailsOptions'],
                'area_from_id' => $value['area_from_id']['id'],
                'area_to_id' => $value['area_to_id']['id'],
                'station_to_id' => $value['station_to_id']['id'],
                'details' => $value['details'],
                'whereForm' => $value['whereForm'],
                'whereTo' => $value['whereTo'],
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

        $timing = $request->input('timingDetails');

        $timingDetails = TimingDetails::create([
            'direction_id' => $direction->id,
            'date' => Carbon::parse($timing['date'])->format('Y-m-d'),
            'avto_number' => $timing['avto_number'],
            'avto_model' => $timing['avto_model'],
            'conclusion' => $timing['conclusion'],
            'persons' => $timing['persons'],
            'technic_speed' => $request->input('technic_speed'),
            'traffic_speed' => $request->input('traffic_speed'),
        ]);

        return response()->json(['success' => true, 'message' => 'Хронометраж успешно создан']);
    }

    public function destroy(Request $request, $id)
    {
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Хронометраж не найден']);
        }
        //Get old timings and delete
        $dTiming = $result->timing;
        foreach ($dTiming as $key => $item) {
            $item->delete();
        }
        //Get timing details and delete
        // $dTimingDetails = $result->timingDetails;
        // foreach ($dTimingDetails as $key => $details) {
        //     $details->delete();
        // }
        // $result->delete();

        return response()->json(['success' => true, 'message' => 'Хронометраж удален']);
    }
}