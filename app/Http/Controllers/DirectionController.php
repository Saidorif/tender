<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direction;
use App\TimingDetails;
use App\PassportTiming;
use App\Region;
use App\Reys;
use App\DirectionCar;
use App\ReysTime;
use App\DirectionReq;
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
        $result = Direction::with([
            'regionToWith',
            'regionFromWith',
            'areaFromWith',
            'areaToWith',
            'timingWith',
            'timingDetails',
            'type',
            'stationFrom',
            'stationTo',
            'carsWith',
            'schemaDetails'
        ])->find($id);
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
            'tarif'  => 'required|integer',
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
            'cars' => 'nullable|array',
            'cars.*.busmarka_id' => 'required|integer',
            'cars.*.busmodel_id' => 'required|integer',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction = Direction::create([
            'pass_number' => $inputs['pass_number'],
            'tarif' => $inputs['tarif'],
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

        foreach ($inputs['cars'] as $key => $car) {
            $direction_car = DirectionCar::create([
                'busmarka_id' => $car['busmarka_id'],
                'busmodel_id' => $car['busmodel_id'],
                'bustype_id' => $car['bustype_id'],
                'tclass_id' => $car['tclass_id'],
                'direction_id' => $direction->id
            ]);
        }

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
        // $all_reg_ids = array_merge($region_ids,$area_ids);
        $validator = Validator::make($request->all(), [            
            'pass_number'  => 'required|string',
            'tarif'  => 'required|integer',
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
            'cars' => 'nullable|array',
            'cars.*.busmarka_id' => 'required|integer',
            'cars.*.busmodel_id' => 'required|integer',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction->update([
            'pass_number' => $inputs['pass_number'],
            'tarif' => $inputs['tarif'],
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

        foreach ($inputs['cars'] as $key => $car) {
            $direction_car = DirectionCar::create([
                'busmarka_id' => $car['busmarka_id'],
                'busmodel_id' => $car['busmodel_id'],
                'bustype_id' => $car['bustype_id'],
                'tclass_id' => $car['tclass_id'],
                'direction_id' => $direction->id
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Направление успешно обновлен']);
    }

    public function deleteDirectionCar(Request $request,$id)
    {
        $direction_car = DirectionCar::find($id);
        if(!$direction_car){
            return response()->json(['error' => true, 'message' => 'Автотранспорт не найден']);
        }
        $direction_car->delete();
        return response()->json(['success' => true, 'message' => 'Автотранспорт удален']);
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
                $result[$key]['ddd'][] = (int)$timing['distance_from_start_station'];
                if($key != 0){
                    $distance_test = array_sum($result[$key]['ddd']);
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
            'data.count_bus'  => 'required|integer',
            'data.reys_from_count'  => 'required|integer',
            'data.reys_to_count'  => 'required|integer',
            'data.whereFrom'  => 'required|array',
            'data.whereFrom.reyses'  => 'required|array',
            'data.whereFrom.reyses.*'  => 'required|array',
            'data.whereFrom.reyses.*.*.start'  => 'nullable|string',
            'data.whereFrom.reyses.*.*.end'  => 'nullable|string',
            'data.whereFrom.reyses.*.*.where'  => 'required|array',
            'data.whereTo'  => 'required|array',
            'data.whereTo.reyses'  => 'required|array',
            'data.whereTo.reyses.*'  => 'required|array',
            'data.whereTo.reyses.*.*.start'  => 'nullable|string',
            'data.whereTo.reyses.*.*.end'  => 'nullable|string',
            'data.whereTo.reyses.*.*.where'  => 'required|array',
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
            $reysTimes = $value->reysTimes;
            foreach ($reysTimes as $key => $item) {
                $item->status = 'inactive';
                $item->save();
            }
        }
        $inputs = $request->input('data');
        $result = [];
        $from = $direction->regionFrom->name;
        $to = $direction->regionTo->name;
        //Get data and store

        foreach ($inputs['whereFrom']['reyses'] as $key => $reyses_from) {
            $where_type = 'region';
            if (array_key_exists('region_id', $inputs['whereFrom']['where'])) {
                $where_type = 'area';
            }
            if(array_key_exists('region_id', $inputs['whereFrom']['where']) && array_key_exists('area_id', $inputs['whereFrom']['where'])){
                $where_type = 'station';
            }
            $reys = Reys::create([
                'direction_id' => $direction->id,
                'station_id'   => $inputs['whereFrom']['where']['id'],
                'stations'     => $inputs['whereFrom']['stations'],
                'where'        => $inputs['whereFrom']['where'],
                'from'         => $inputs['whereFrom']['from'],
                'where_type'   => $where_type,
                'status'       => 'active',
                'type'         => 'from',
                'count_bus'    => $inputs['count_bus'],
                'reys_from_count'=> $inputs['reys_from_count'],
                'reys_to_count'  => $inputs['reys_to_count'],
            ]);
            foreach ($reyses_from as $key => $item) {
                $reysTime = ReysTime::create([
                    'start' => $item['start'],
                    'end' => $item['end'],
                    'where' => $item['where'],
                    'status' => 'active',
                    'direction_id' => $direction->id,
                    'reys_id' => $reys->id,
                ]);
            }
        }
        foreach ($inputs['whereTo']['reyses'] as $key => $reyses_from) {
            $where_type = 'region';
            if (array_key_exists('region_id', $inputs['whereTo']['where'])) {
                $where_type = 'area';
            }
            if(array_key_exists('region_id', $inputs['whereTo']['where']) && array_key_exists('area_id', $inputs['whereTo']['where'])){
                $where_type = 'station';
            }
            $reys = Reys::create([
                'direction_id' => $direction->id,
                'station_id'   => $inputs['whereTo']['where']['id'],
                'where'        => $inputs['whereTo']['where'],
                'from'         => $inputs['whereTo']['from'],
                'stations'     => $inputs['whereTo']['stations'],
                'where_type'   => $where_type,
                'status'       => 'active',
                'type'         => 'to',
                'count_bus'    => $inputs['count_bus'],
                'reys_from_count'=> $inputs['reys_from_count'],
                'reys_to_count'  => $inputs['reys_to_count'],
            ]);
            foreach ($reyses_from as $key => $item) {
                $reysTime = ReysTime::create([
                    'start' => $item['start'],
                    'end' => $item['end'],
                    'where' => $item['where'],
                    'status' => 'active',
                    'direction_id' => $direction->id,
                    'reys_id' => $reys->id,
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
        $result = [
            'whereFrom' => [],
            'whereTo' => [],
        ];
        $reysesFrom = Reys::where(['direction_id' => $id,'type' => 'from'])->get();
        $reysesTo   = Reys::where(['direction_id' => $id,'type' => 'to'])->get();

        foreach ($reysesFrom as $key => $reys_from) {
            // if($reys->where_type == 'region'){
            //     $station = $reys->region;
            // }
            // if($reys->where_type == 'area'){
            //     $station = $reys->area;
            // }
            // if($reys->where_type == 'station'){
            //     $station = $reys->station;
            // }
            // $item = $reys->toArray();
            // $item[] = $station;
            $reys_times = $reys_from->reysTimes;
            $result['whereFrom'][] = $reys_from;
        }
        foreach ($reysesTo as $key => $reys_to) {
            $reys_times = $reys_to->reysTimes;
            $result['whereTo'][] = $reys_to;
        }
        // $result = array_values($result);
        return response()->json([
            'success' => true,
            'count' => count($reysesFrom),
            'count' => count($reysesTo),
            'result' => $result,
        ]);
    }

    public function requirement(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        if($direction->requirement){
            return response()->json(['success' => true, 'result' => $direction->requirement]);
        }
        $result = [];
        $from_name = $direction->from_where['name'];
        $from_id   = $direction->from_where['id'];
        $to_name   = $direction->timing->last()->whereTo['name'];
        $to_id     = $direction->timing->last()->whereTo['id'];
        $ptimings  = $direction->timing->toArray();
        $data = [
            'direction_id'                  => $direction->id,
            'auto_type'                     => $direction->type->id,
            'auto_type_name'                => $direction->type->name,
            'auto_model_class'              => $direction->cars->pluck('id'),
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
            'reyses_count'                  => count($direction->schedule),
            'reyses_from_value'             => '',
            'reyses_from_name'              => $from_name,
            'reyses_to_value'               => '',
            'reyses_to_name'                => $to_name,
            'schedule_begin_time'           => '-',//Дастлабки рейс (ишни бошлаш) вақти
            'schedule_begin_from'           => '00:00',//Toshkent томондан
            'schedule_begin_to'             => '00:00',//Nukus томондан
            'schedule_end_time'             => '-',//Сўнги рейс (ишни тугалланиш) вақти
            'schedule_end_from'             => '00:00',//Toshkent томондан
            'schedule_end_to'               => '00:00',//Nukus томондан 
            'station_intervals'             => '?',
            'reys_time'                     => array_sum(array_column($ptimings, 'spendtime_between_station')),
            'reys_from_value'               => '00:00',
            'reys_to_value'                 => '00:00',
            'schedules'                     => '-',
            'tarif'                         => '?',
            'tarif_one_km'                  => '?',
            'tarif_city'                    => '?',
            'transports_capacity'           => '',
            'transports_seats'              => '',
            'minimum_bal'                   => '?',
        ];
        $direction_req = DirectionReq::create($data);
        $res = DirectionReq::find($direction_req->id);
        return response()->json(['success' => true, 'result' => $res]);
    }

    public function storeRequirement(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'direction_id' => 'required|integer',
            'auto_type' => 'required|integer',
            'auto_type_name' => 'required|string',
            // 'auto_model_class' => 'required|string',
            'auto_trans_count' => 'required|string',
            'auto_trans_working_days' => 'required|string',
            'auto_trans_weekends' => 'required|string',
            'auto_trans_status' => 'required|string',
            'direction_total_length' => 'required|string',
            'direction_from_value' => 'required|string',
            'direction_from_name' => 'required|string',
            'direction_to_value' => 'required|string',
            'direction_to_name' => 'required|string',
            'stations_count' => 'required|string',
            'stations_from_name' => 'required|string',
            'stations_to_name' => 'required|string',
            'seasonal' => 'required|string',
            'reyses_count' => 'required|string',
            'reyses_from_value' => 'required|string',
            'reyses_from_name' => 'required|string',
            'reyses_to_value' => 'required|string',
            'reyses_to_name' => 'required|string',
            'schedule_begin_time' => 'required|string',
            'schedule_begin_from' => 'required|string',
            'schedule_begin_to' => 'required|string',
            'schedule_end_time' => 'required|string',
            'schedule_end_from' => 'required|string',
            'schedule_end_to' => 'required|string',
            'station_intervals' => 'required|string',
            'reys_time' => 'required|string',
            'reys_from_value' => 'required|string',
            'reys_to_value' => 'required|string',
            'schedules' => 'required|string',
            'tarif' => 'required|string',
            'tarif_one_km' => 'required|string',
            'tarif_city' => 'required|string',
            'transports_capacity' => 'required|string',
            'transports_seats' => 'required|string',
            'minimum_bal' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $inputs = $request->all();
        unset($inputs['auto_model_class']);
        $inputs['direction_id'] = $direction->id;

        $direction->requirement->update($inputs);
        return response()->json(['success' => true, 'message' => 'Требование обновлен']);
    }
}
