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
use App\PassportTarif;
use Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DirectionController extends Controller
{
    public function index(Request $request)
    {
        $result = Direction::with(['regionTo','regionFrom','areaFrom','areaTo'])->orderByDesc('id')->paginate(20);
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
            'from_type'  => 'required|string',
            'to_type'  => 'required|string',
            'tarif'  => 'nullable|integer',
            'year'  => 'required|string',
            'distance'  => 'nullable|numeric|min:0,99|max:999999999,99',
            'profitability'  => ['required',Rule::in(['unprofitable','profitable','middle']),],
            'type_id'  => 'required|integer',
            'region_from' => 'required|array',
            'region_to' => 'required|array',
            'from_where'=> 'required',
            'seasonal'=> ['required',Rule::in(['seasonal','always']),],
            'region_from.region_id'=> ['required',Rule::in($region_ids),],
            'region_from.area_id'  => ['nullable',Rule::in($area_ids),],
            'region_from.station_id'  => 'nullable|integer',
            'region_to.region_id'  => ['required',Rule::in($region_ids),],
            'region_to.area_id'    => ['nullable',Rule::in($area_ids),],
            'region_to.station_id'    => 'nullable|integer',
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
            'from_type' => $inputs['from_type'],
            'to_type' => $inputs['to_type'],
            'tarif' => $inputs['tarif'],
            'year' => Carbon::parse($inputs['year'])->format('Y-m-d'),
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
        $from_name = '';
        $to_name = '';
        if($inputs['from_type'] == 'region'){
            $from_name = $direction->regionFrom->name;
        }
        if($inputs['from_type'] == 'area'){
            $from_name = $direction->areaFrom->name;
        }
        if($inputs['from_type'] == 'station'){
            $from_name = $direction->stationFrom->name;
        }
        if($inputs['to_type'] == 'region'){
            $to_name = $direction->regionTo->name;
        }
        if($inputs['to_type'] == 'area'){
            $to_name = $direction->areaTo->name;
        }
        if($inputs['to_type'] == 'station'){
            $to_name = $direction->stationTo->name;
        }
        $direction->name = $from_name.'-'.$to_name;
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
        $validator = Validator::make($request->all(), [            
            'pass_number'  => 'required|string',
            'from_type'  => 'required|string',
            'to_type'  => 'required|string',
            'tarif'  => 'nullable|integer',
            'year'  => 'required|string',
            'distance'  => 'nullable|numeric|min:0,99|max:999999999,99',
            'profitability'  => ['required',Rule::in(['unprofitable','profitable','middle']),],
            'type_id'  => 'required|integer',
            'region_from' => 'required|array',
            'region_to' => 'required|array',
            'from_where'=> 'required',
            'seasonal'=> ['required',Rule::in(['seasonal','always']),],
            'region_from.region_id'=> ['required',Rule::in($region_ids),],
            'region_from.area_id'  => ['nullable',Rule::in($area_ids),],
            'region_from.station_id'  => 'nullable|integer',
            'region_to.region_id'  => ['required',Rule::in($region_ids),],
            'region_to.area_id'    => ['nullable',Rule::in($area_ids),],
            'region_to.station_id'    => 'nullable|integer',
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
        $from_name = '';
        $to_name = '';
        if($inputs['from_type'] == 'region'){
            $from_name = $direction->regionFrom->name;
        }
        if($inputs['from_type'] == 'area'){
            $from_name = $direction->areaFrom->name;
        }
        if($inputs['from_type'] == 'station'){
            $from_name = $direction->stationFrom->name;
        }
        if($inputs['to_type'] == 'region'){
            $to_name = $direction->regionTo->name;
        }
        if($inputs['to_type'] == 'area'){
            $to_name = $direction->areaTo->name;
        }
        if($inputs['to_type'] == 'station'){
            $to_name = $direction->stationTo->name;
        }
        $direction->update([
            'pass_number' => $inputs['pass_number'],
            'from_type' => $inputs['from_type'],
            'to_type' => $inputs['to_type'],
            'tarif' => (int)$inputs['tarif'],
            'year' => Carbon::parse($inputs['year'])->format('Y-m-d'),
            'distance' => $inputs['distance'],
            'profitability' => $inputs['profitability'],
            'type_id' => $inputs['type_id'],
            'name' => $from_name.'-'.$to_name,
            'from_where' => $inputs['from_where'],
            'seasonal' => $inputs['seasonal'],
            'station_from_id' => $inputs['region_from']['station_id'],
            'region_from_id' => $inputs['region_from']['region_id'],
            'area_from_id' => $inputs['region_from']['area_id'],
            'station_to_id' => $inputs['region_to']['station_id'],
            'region_to_id' => $inputs['region_to']['region_id'],
            'area_to_id' => $inputs['region_to']['area_id'],
        ]);

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
        $total_result = [];
        $test = [];
        foreach($direction->passport_tarif as $index => $passportTarif){
            $summa = $passportTarif->summa;
            $summa_bagaj = $passportTarif->summa_bagaj;
            $result = [];
            for ($i=0; $i < count($ptimings); $i++) {
                foreach ($ptimings as $key => $timing) {
                    $result[$i][$key]['ddd'] = 0;
                    if($key != 0 && $i != 0){
                        $result[$i][$key]['ddd'] += round($timing['distance_between_station'],2);
                        if($key == 1 ){
                            $distance_test = $timing['distance_between_station'];
                        }else{
                            $distance_test = floatval($result[$i][$key - 1]['distance_test']) + $result[$i][$key]['ddd'];
                        }
                    }
                    else{
                        $distance_test = round($timing['distance_from_start_station'],2);
                    }
                    if($ptimings[$i]['whereForm']['name'] == $timing['whereTo']['name'] || $i > $key){
                        $result[$i][$key]['from_name'] = '';
                        $result[$i][$key]['to_name'] = '';
                        $result[$i][$key]['distance'] = '';
                        $result[$i][$key]['distance_test'] = '';
                        $result[$i][$key]['summa'] = round($summa,2);
                        $result[$i][$key]['summa_bagaj'] = round($summa_bagaj,2);
                        $result[$i][$key]['tarif'] = '';
                        $result[$i][$key]['tarif_bagaj'] = '';
                    }else{
                        $result[$i][$key]['from_name'] = $ptimings[$i]['whereForm']['name'];
                        $result[$i][$key]['to_name'] = $timing['whereTo']['name'];
                        $result[$i][$key]['distance_test'] = round($distance_test,2);
                        $result[$i][$key]['distance'] = round($distance_test,2);
                        $result[$i][$key]['summa'] = round($summa,2);
                        $result[$i][$key]['summa_bagaj'] = round($summa_bagaj,2);
                        $result[$i][$key]['tarif'] = round($result[$i][$key]['summa'] * $result[$i][$key]['distance_test'],2);
                        $result[$i][$key]['tarif_bagaj'] = round($result[$i][$key]['summa_bagaj'] * $result[$i][$key]['distance_test'],2);
                    }
                }
            }
            $total_result[] = [
                'items' => $result,
                'tarif' => $passportTarif
            ];
        }
        return response()->json(['success' => true, 'result' => $total_result]);
    }

    //Store direction tarifs
    public function storeTarif(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [            
            'summa'  => 'required|integer',
            'summa_bagaj'  => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $inputs = $request->all();
        $inputs['direction_id'] = $id;
        $inputs['status'] = 'pending';
        $passport_tarif = PassportTarif::create($inputs);
        return response()->json(['success' => true, 'message' => 'Passport tarif created successfully']);
    }
    
    //List direction tarifs
    public function listTarif(Request $request)
    {
        $directions = Direction::all();
        $result = [];
        foreach($directions as $key => $dir){
            $passport_tarifs = $dir->passport_tarif;
            $result[$key] = ['name' => $dir->name,'tarifs' => $passport_tarifs];
        }
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    //Direction tarifs approve
    public function listTarifApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'tarif_id'  => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $passportTarif = PassportTarif::find($request->input('tarif_id'));
        if(!$passportTarif){
            return response()->json(['error' => true, 'message' => 'Passport tarif not found']);
        }
        //Update direction tarif
        $direction = $passportTarif->direction;
        $direction->tarif = $passportTarif->summa;
        $direction->save();
        //Update all tarifs status
        foreach($direction->passport_tarif as $tarif){
            $tarif->status = 'pending';
            $tarif->save();
        }
        //Update the tarif status
        $passportTarif->status = 'approved';
        $passportTarif->approved_id = $request->user()->id;
        $passportTarif->save();

        return response()->json(['success' => true, 'message' => 'Passport tarif approved']);
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
            'data.whereTo.reyses.*.*.bus_order'  => 'nullable|string',
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
        // return $inputs;

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
                    'bus_order' => $item['bus_order'],
                    'where' => $item['where'],
                    'status' => 'active',
                    'direction_id' => $direction->id,
                    'reys_id' => $reys->id,
                ]);
            }
        }
        foreach ($inputs['whereTo']['reyses'] as $key => $reyses_to) {
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
            foreach ($reyses_to as $key => $to_item) {
                $reysTime = ReysTime::create([
                    'start' => $to_item['start'],
                    'end' => $to_item['end'],
                    'bus_order' => $to_item['bus_order'],
                    'where' => $to_item['where'],
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
        $reysesFrom = Reys::where(['direction_id' => $id,'type' => 'from','status' => 'active'])->get();
        $reysesTo   = Reys::where(['direction_id' => $id,'type' => 'to','status' => 'active'])->get();

        foreach ($reysesFrom as $key => $reys_from) {
            $reys_times = $reys_from->reysTimes;
            $result['whereFrom'][] = $reys_from;
        }
        foreach ($reysesTo as $reys_to) {
            $reys_times = $reys_to->reysTimes;
            $result['whereTo'][] = $reys_to;
        }
        return response()->json([
            'success' => true,
            'count' => count($reysesFrom) + count($reysesTo),
            'reysesTo' => count($reysesTo),
            'reysesFrom' => count($reysesFrom),
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
        $reysesFrom = Reys::where(['direction_id' => $id,'type' => 'from','status' => 'active'])->get();
        $reysesTo   = Reys::where(['direction_id' => $id,'type' => 'to','status' => 'active'])->get();
        $data = [
            'direction_id'                  => $direction->id,
            'auto_type'                     => $direction->cars->first()->bustype->id,
            'auto_type_name'                => $direction->cars->first()->bustype->name,
            'auto_model_class'              => $direction->carsWith,//->pluck('id'),
            'auto_trans_count'              => $direction->schedule->first()->count_bus,
            'auto_trans_working_days'       => '',
            'auto_trans_weekends'           => '',
            'auto_trans_status'             => 'Ишлаб чиқарилганига 14 йилдан ошмаган',
            'direction_total_length'        => $direction->timingWith->last()->distance_from_start_station,
            'direction_from_value'          => $from_id,
            'direction_from_name'           => $from_name,
            'direction_to_value'            => $to_id,
            'direction_to_name'             => $to_name,
            'stations_count'                => count($direction->timing),
            'stations_from_name'            => $from_name,
            'stations_to_name'              => $to_name,
            'stations_from_value'           => 0,
            'stations_to_value'             => 0,
            'seasonal'                      => $direction->seasonal,
            'reyses_count'                  => count($direction->schedule),
            'reyses_from_value'             => '',
            'reyses_from_name'              => $from_name,
            'reyses_to_value'               => '',
            'reyses_to_name'                => $to_name,
            'schedule_begin_time'           => '-',//Дастлабки рейс (ишни бошлаш) вақти
            'schedule_begin_from'           => $reysesTo->first()->reysTimes->first()->start,//Toshkent томондан
            'schedule_begin_to'             => $reysesFrom->first()->reysTimes->first()->start,//Nukus томондан
            'schedule_end_time'             => '-',//Сўнги рейс (ишни тугалланиш) вақти
            'schedule_end_from'             => $reysesTo->last()->reysTimes->first()->start,//Toshkent томондан
            'schedule_end_to'               => $reysesFrom->last()->reysTimes->first()->start,//Nukus томондан 
            'station_intervals'             => '?',
            'reys_time'                     => array_sum(array_column($ptimings, 'spendtime_between_station')) + array_sum(array_column($ptimings, 'spendtime_to_stay_station')),
            'reys_from_value'               => '00:00',
            'reys_to_value'                 => '00:00',
            'schedules'                     => '-',
            'tarif'                         => $direction->tarif,
            'tarif_one_km'                  => $direction->tarif,
            'tarif_city'                    => '?',
            'transports_capacity'           => '',
            'transports_seats'              => '',
            'minimum_bal'                   => '?',
        ];
        // $direction_req = DirectionReq::create($data);
        // $res = DirectionReq::find($direction_req->id);
        return response()->json(['success' => true, 'result' => $data]);
    }

    public function storeRequirement(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $validator = Validator::make($request->all(), [            
            'direction_id' => 'required|integer',
            'auto_type' => 'nullable|integer',
            'auto_type_name' => 'nullable|string',
            // 'auto_model_class' => 'nullable|string',
            'auto_trans_count' => 'nullable|integer',
            'auto_trans_working_days' => 'nullable|string',
            'auto_trans_weekends' => 'nullable|string',
            'auto_trans_status' => 'nullable|string',
            'direction_total_length' => 'nullable|string',
            'direction_from_value' => 'nullable|integer',
            'direction_from_name' => 'nullable|string',
            'direction_to_value' => 'nullable|string',
            'direction_to_name' => 'nullable|string',
            'stations_count' => 'nullable|string',
            'stations_from_name' => 'nullable|string',
            'stations_to_name' => 'nullable|string',
            'stations_from_value' => 'nullable|string',
            'stations_to_value' =>  'nullable|string',
            'seasonal' => 'nullable|string',
            'reyses_count' => 'nullable|string',
            'reyses_from_value' => 'nullable|string',
            'reyses_from_name' => 'nullable|string',
            'reyses_to_value' => 'nullable|string',
            'reyses_to_name' => 'nullable|string',
            'schedule_begin_time' => 'nullable|string',
            'schedule_begin_from' => 'nullable|string',
            'schedule_begin_to' => 'nullable|string',
            'schedule_end_time' => 'nullable|string',
            'schedule_end_from' => 'nullable|string',
            'schedule_end_to' => 'nullable|string',
            'station_intervals' => 'nullable|string',
            'reys_time' => 'nullable|string',
            'reys_from_value' => 'nullable|string',
            'reys_to_value' => 'nullable|string',
            'schedules' => 'nullable|string',
            'tarif' => 'nullable|string',
            'tarif_one_km' => 'nullable|string',
            'tarif_city' => 'nullable|string',
            'transports_capacity' => 'nullable|string',
            'transports_seats' => 'nullable|string',
            'minimum_bal' => 'nullable|string',
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
