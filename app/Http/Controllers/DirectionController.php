<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direction;
use App\TimingDetails;
use App\PassportTiming;
use App\Region;
use App\Reys;
use App\ReysTime;
use App\Area;
use Validator;
use Illuminate\Validation\Rule;

class DirectionController extends Controller
{
    public function index(Request $request)
    {
        $result = Direction::with(['regionTo','regionFrom','areaFrom','areaTo'])->orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }

        $result = Direction::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $builder = Direction::query();
        $builder->where('name','LIKE', '%'.$request->input('name').'%');
        $builder->orWhere('pass_number','LIKE', '%'.$request->input('name').'%');
        $result = $builder->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function timingdetails(Request $request)
    {
        $result = TimingDetails::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = Direction::with(['regionToWith','regionFromWith','areaFromWith','areaToWith','timingWith','timingDetails','type'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        // $result->from_where = json_decode( $result->from_where, true );
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $region_ids = Region::pluck('id');
        $area_ids = Area::pluck('id');
        $validator = Validator::make($request->all(), [            
            'pass_number'  => 'required|string',
            'year'  => 'required|string',
            'distance'  => 'required|string',
            'profitability'  => ['required',Rule::in(['unprofitable','profitable','middle']),],
            'type_id'  => 'required|integer',
            'region_from' => 'required|array',
            'region_to' => 'required|array',
            'from_where'=> 'required',
            'seasonal'=> ['required',Rule::in(['seasonal','always']),],
            'region_from.region_id'=> ['required',Rule::in($region_ids),],
            'region_from.area_id'  => ['nullable',Rule::in($area_ids),],
            'region_from.station_id'  => ['nullable',Rule::in($area_ids),],
            'region_to.region_id'  => ['required',Rule::in($region_ids),],
            'region_to.area_id'    => ['nullable',Rule::in($area_ids),],
            'region_to.station_id'    => ['nullable',Rule::in($area_ids),],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction = Direction::create([
            'pass_number' => $inputs['pass_number'],
            'year' => $inputs['year'],
            'distance' => $inputs['distance'],
            'profitability' => $inputs['profitability'],
            'type_id' => $inputs['type_id'],
            'from_where' => $inputs['from_where'],
            'seasonal' => $inputs['seasonal'],
            'station_from_id' => $inputs['region_from']['station_id'],
            'region_from_id' => $inputs['region_from']['region_id'],
            'area_from_id' => $inputs['region_from']['area_id'],
            'station_to_id' => $inputs['region_to']['station_id'],
            'region_to_id' => $inputs['region_to']['region_id'],
            'area_to_id' => $inputs['region_to']['area_id'],
        ]);
        $direction->name = $direction->regionFrom->name.'-'.$direction->regionTo->name;
        $direction->save();

        return response()->json(['success' => true, 'message' => 'Направление успешно создан','result' => $direction]);
    }

    public function update(Request $request, $id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $region_ids = Region::pluck('id');
        $area_ids = Area::pluck('id');
        $all_reg_ids = array_merge($region_ids,$area_ids);
        $validator = Validator::make($request->all(), [            
            'pass_number'  => 'required|string',
            'year'  => 'required|string',
            'distance'  => 'required|string',
            'profitability'  => ['required',Rule::in(['unprofitable','profitable','middle']),],
            'type_id'  => 'required|integer',
            'region_from' => 'required|array',
            'region_to' => 'required|array',
            'from_where'=> 'required',
            'seasonal'=> ['required',Rule::in(['seasonal','always']),],
            'region_from.*.region_id'=> ['required',Rule::in($region_ids),],
            'region_from.*.area_id'  => ['nullable',Rule::in($area_ids),],
            'region_from.*.station_id'  => ['nullable',Rule::in($area_ids),],
            'region_to.*.region_id'  => ['required',Rule::in($region_ids),],
            'region_to.*.area_id'    => ['nullable',Rule::in($area_ids),],
            'region_to.*.station_id'    => ['nullable',Rule::in($area_ids),],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction->update([
            'pass_number' => $inputs['pass_number'],
            'year' => $inputs['year'],
            'distance' => $inputs['distance'],
            'profitability' => $inputs['profitability'],
            'type_id' => $inputs['type_id'],
            'from_where' => $inputs['from_where'],
            'seasonal' => $inputs['seasonal'],
            'station_from_id' => $inputs['region_from']['station_id'],
            'region_from_id' => $inputs['region_from']['region_id'],
            'area_from_id' => $inputs['region_from']['area_id'],
            'station_to_id' => $inputs['region_to']['station_id'],
            'region_to_id' => $inputs['region_to']['region_id'],
            'area_to_id' => $inputs['region_to']['area_id'],
        ]);
        $direction->name = $direction->regionFrom->name.'-'.$direction->regionTo->name;
        $direction->save();

        return response()->json(['success' => true, 'message' => 'Направление успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Направление удален']);
    }

    public function timingtarif(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $ptimings = $direction->timing->toArray();
        $result = [];
        $test = [];
        for ($i=0; $i < count($ptimings); $i++) {
            foreach ($ptimings as $key => $timing) {
                $result[$i]['ddd'][] = (int)$timing['distance_from_start_station'];
                if($i != 0){
                    $distance_test = array_sum($result[$i]['ddd']);
                }else{
                    $distance_test = (int)$timing['distance_from_start_station'];
                }
                if($ptimings[$i]['whereForm']['name'] == $timing['whereTo']['name'] || $i > $key){
                    $distance_test += (int)$timing['distance_from_start_station'];
                    $result[$i][$key]['from_name'] = '';
                    $result[$i][$key]['to_name'] = '';
                    $result[$i][$key]['distance'] = '';
                    $result[$i][$key]['distance_test'] = '';
                    $result[$i][$key]['summa'] = 65;
                    $result[$i][$key]['summa_bagaj'] = 35;
                    $result[$i][$key]['tarif'] = '';
                    $result[$i][$key]['tarif_bagaj'] = '';
                }else{
                    $result[$i][$key]['from_name'] = $ptimings[$i]['whereForm']['name'];
                    $result[$i][$key]['to_name'] = $timing['whereTo']['name'];
                    $result[$i][$key]['distance'] = (int)$timing['distance_from_start_station'];
                    $result[$i][$key]['distance_test'] = $distance_test;
                    $result[$i][$key]['summa'] = 65;
                    $result[$i][$key]['summa_bagaj'] = 35;
                    $result[$i][$key]['tarif'] = $result[$i][$key]['summa'] * $result[$i][$key]['distance_test'];
                    $result[$i][$key]['tarif_bagaj'] = $result[$i][$key]['summa_bagaj'] * $result[$i][$key]['distance_test'];
                }
            }
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function schedule(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [            
            'data'  => 'required|array',
            'data.*.whereFrom'  => 'required|array',
            'data.*.whereFrom.reyses'  => 'required|array',
            'data.*.whereTo'  => 'required|array',
            'data.*.whereTo.reyses'  => 'required|array',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $schedules = $direction->schedule;
        foreach ($schedules as $key => $value) {
            $value->status = 'inactive';
            $value->save();
        }
        $inputs = $request->input('data');
        $result = [];
        $from = $direction->regionFrom->name;
        $to = $direction->regionTo->name;

        // foreach ($inputs as $key => $value) {
        //     foreach ($value['reyses_from']['reyses'] as $key => $item) {
        //         $where_type = 'region';
        //         if (array_key_exists('region_id', $value['reyses_from']['where'])) {
        //             $where_type = 'area';
        //         }
        //         if(array_key_exists('region_id', $value['reyses_from']['where']) && array_key_exists('area_id', $value['reyses_from']['where'])){
        //             $where_type = 'station';
        //         }
        //         $reys = Reys::create([
        //             'direction_id' => 1,
        //             'station_id'   => $value['stationName']['id'],
        //             'where_id'     => $value['reyses_from']['where']['id'],
        //             'where_type'   => $where_type,
        //             'time_from_1'  => $item['time_from_1'],
        //             'time_from_2'  => $item['time_from_2'],
        //             'time_from_3'  => $item['time_from_3'],
        //             'time_from_4'  => $item['time_from_4'],
        //             'time_to_1'    => $item['time_to_1'],
        //             'time_to_2'    => $item['time_to_2'],
        //             'time_to_3'    => $item['time_to_3'],
        //             'time_to_4'    => $item['time_to_4'],
        //         ]);
        //         $result[] = $reys;
        //     }
        //     foreach ($value['reyses_to']['reyses'] as $key => $item) {
                // $where_type = 'region';
                // if (array_key_exists('region_id', $value['reyses_from']['where'])) {
                //     $where_type = 'area';
                // }
                // if(array_key_exists('region_id', $value['reyses_from']['where']) && array_key_exists('area_id', $value['reyses_from']['where'])){
                //     $where_type = 'station';
                // }
                // $reys = Reys::create([
                //     'direction_id' => 1,
                //     'station_id'   => $value['stationName']['id'],
                //     'where_id'     => $value['reyses_to']['where']['id'],
                //     'where_type'   => $where_type,
                //     'time_from_1'  => $item['time_from_1'],
                //     'time_from_2'  => $item['time_from_2'],
                //     'time_from_3'  => $item['time_from_3'],
                //     'time_from_4'  => $item['time_from_4'],
                //     'time_to_1'    => $item['time_to_1'],
                //     'time_to_2'    => $item['time_to_2'],
                //     'time_to_3'    => $item['time_to_3'],
                //     'time_to_4'    => $item['time_to_4'],
                // ]);
        //         $result[] = $reys;
        //     }
        // }
        //Get data and store
        foreach ($inputs['whereFrom']['reyses'] as $key => $reyses_from) {
            foreach ($reyses_from as $key => $item) {
                $where_type = 'region';
                if (array_key_exists('region_id', $value['whereFrom']['where'])) {
                    $where_type = 'area';
                }
                if(array_key_exists('region_id', $value['whereFrom']['where']) && array_key_exists('area_id', $value['whereFrom']['where'])){
                    $where_type = 'station';
                }
                $reys = Reys::create([
                    'direction_id' => 1,
                    'station_id'   => $value['whereFrom']['where']['id'],
                    'where'        => $value['whereFrom']['where'],
                    'where_type'   => $where_type,
                    'status'       => 'active',
                    'type'         => 'from',
                ]);
                foreach ($item as $key => $value) {
                    $reysTime = ReysTime::create([
                        'start' => $value['from_date'],
                        'end' => $value['to_date'],
                        'where' => $value['where'],
                        'status' => 'active',
                        'direction_id' => 'active',
                        'reys_id' => 'active',
                    ]);
                }
            }
        }
        foreach ($inputs['whereTo']['reyses'] as $key => $reyses_from) {
            foreach ($reyses_from as $key => $item) {
                $where_type = 'region';
                if (array_key_exists('region_id', $value['whereFrom']['where'])) {
                    $where_type = 'area';
                }
                if(array_key_exists('region_id', $value['whereFrom']['where']) && array_key_exists('area_id', $value['whereFrom']['where'])){
                    $where_type = 'station';
                }
                $reys = Reys::create([
                    'direction_id' => 1,
                    'station_id'   => $value['whereFrom']['where']['id'],
                    'where'        => $value['whereFrom']['where'],
                    'where_type'   => $where_type,
                    'status'       => 'active',
                    'type'         => 'to',
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Расписание сохранено'
        ]);
    }

    public function getSchedule(Request $request, $id)
    {
        $result = [];
        $reyses = Reys::where(['direction_id' => $id,'status' => 'active'])->get();
        foreach ($reyses as $key => $reys) {
            if($reys->where_type == 'region'){
                $station = $reys->region;
            }
            if($reys->where_type == 'area'){
                $station = $reys->area;
            }
            if($reys->where_type == 'station'){
                $station = $reys->station;
            }
            $item = $reys->toArray();
            // $item[] = $station;
            $result[$reys->where_id][] = $item;
        }
        $result = array_values($result);
        return response()->json([
            'success' => true,
            'count' => count($reyses),
            'result' => $result,
        ]);
    }

    public function requirement(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $result = [];
        $from_name = $direction->from_where['name'];
        $from_id   = $direction->from_where['id'];
        $to_name   = $direction->timing->last()->whereTo['name'];
        $to_id     = $direction->timing->last()->whereTo['id'];
        $data = [
            'auto_type'                     => $direction->type->type,
            'auto_type_name'                => $direction->type->name,
            'auto_model_class'              => $direction->type->tclasModels,
            'auto_trans_count'              => 10,
            'auto_trans_working_days'       => '',
            'auto_trans_weekends'           => '',
            'auto_trans_status'             => '',
            'direction_total_length'        => $direction->timing->last()->end_speedometer,
            'direction_from_value'          => $from_id,
            'direction_from_name'           => $from_name,
            'direction_to_value'            => $to_id,
            'direction_to_name'             => $to_name,
            'stations_count'                => count($direction->timing),
            'stations_from_name'            => $from_name,
            'stations_to_name'              => $to_name,
            'seasonal'                      => $direction->seasonal,
            'reyses_count'                  => '?',
            'reyses_from_value'             => '',
            'reyses_from_name'              => $from_name,
            'reyses_to_value'               => '',
            'reyses_to_name'                => $to_name,
            'schedule_begin_time'           => '?',
            'schedule_begin_from'           => '?',
            'schedule_begin_to'             => '?',
            'schedule_end_time'             => '?',
            'schedule_end_from'             => '?',
            'schedule_end_to'               => '?',
            'station_intervals'             => '?',
            'reys_time'                     => '?',
            'reys_from_value'               => '?',
            'reys_to_value'                 => '?',
            'schedules'                     => '?',
            'tarif'                         => '?',
            'tarif_one_km'                  => '?',
            'tarif_city'                    => '?',
            'transports_capacity'           => '',
            'transports_seats'              => '',
            'minimum_bal'                   => '?',
        ];
        return response()->json(['success' => true, 'result' => $data]);
    }
}
