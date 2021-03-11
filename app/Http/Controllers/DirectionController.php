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
use App\TenderLot;
use App\User;
use Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DirectionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $builder = Direction::query();
        //по региону!
        if(!empty($inputs['region_id'])){
            $region = $inputs['region_id'];
            // $builder->where(['region_from_id' => $inputs['region_id'],'region_to_id' => $inputs['region_id']]);
            $builder->whereHas('createdBy', function ($query) use ($region){
                $query->where('region_id',$region);
            });
        }
        //по типу маршрута! bus or taxi
        if(!empty($inputs['dir_type'])){
            $builder->where(['dir_type' => $inputs['dir_type']]);
        }
        //по типу авто
        if(!empty($inputs['type_id'])){
            $builder->where(['type_id' => $inputs['type_id']]);
        }
        //по рентабельности
        if(!empty($inputs['profitability'])){
            $builder->where(['profitability' => $inputs['profitability']]);
        }
        //по номеру
        if(!empty($inputs['pass_number'])){
            $builder->where('pass_number','LIKE', '%'.$inputs['pass_number'].'%');
        }
        //по дата открытия
        if(!empty($inputs['year'])){
            $from_year = $inputs['year'].'-01-01';
            $to_year = $inputs['year'].'-12-31';
            $builder->whereBetween('year',[$from_year, $to_year]);
        }
        if($user->role->name == 'admin'){
            $result = $builder->with(['regionTo','regionFrom','areaFrom','areaTo','createdBy'])->orderByDesc('id')->paginate(20);
        }else{
            $result = $builder->with(['regionTo','regionFrom','areaFrom','areaTo','createdBy'])
                            ->orderByDesc('id')
                            ->where(['created_by' => $user->id])
                            ->paginate(20);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function getTarifByNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'number'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->only('number');
        $direction = Direction::where(['pass_number' => $inputs['number']])->first();
        if(!$direction){
            return response()->json(['error' => true,'message' => 'Direction not found']);
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

    public function list(Request $request)
    {
        $user = $request->user();
        if($user->role->name == 'admin'){
            $result = Direction::all();
        }else{
            $result = Direction::where(['region_from_id' => $user->region_id,'region_to_id' => $user->region_id])->get(20);
        }
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function findForUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'region_from_id'  => 'required|integer',
            'region_to_id'  => 'nullable|integer',
            'area_from_id'  => 'nullable|integer',
            'area_to_id'  => 'nullable|integer',
            'type'  => 'nullable|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $builder = PassportTiming::query()
                            ->leftJoin('directions','directions.id','=','passport_timings.direction_id')
                            ->select('passport_timings.id','passport_timings.whereForm','passport_timings.whereTo','passport_timings.direction_id','directions.type_id as type','directions.tarif as tarif');
        $builder->where('passport_timings.region_from_id','=',$inputs['region_from_id']);
        $builder->where('directions.tarif','!=',null);

        if(!empty($inputs['region_to_id'])){
            $builder->where('passport_timings.region_to_id','=',$inputs['region_to_id']);
        }
        if(!empty($inputs['type'])){
            $builder->where('directions.type_id','=',$inputs['type']);
        }
        if(!empty($inputs['area_from_id'])){
            $builder->where('passport_timings.area_from_id','=',$inputs['area_from_id']);
        }
        if(!empty($inputs['area_to_id'])){
            $builder->where('passport_timings.area_to_id','=',$inputs['area_to_id']);
        }
        $result = $builder->get();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function directionInfoForUsers(Request $request, $id)
    {
        
        return response()->json($result);
    }
    
    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $builder = Direction::query();
        if($user->role->name != 'admin'){
            $builder->where(['region_from_id' => $user->region_id]);
        }
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

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $region = $user->region_id;
        if($user->role->name == 'admin'){
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
                'schemaDetails',
            ])->find($id);
        }else{
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
                'schemaDetails',
            ])->whereHas('createdBy', function ($query) use ($region){
                $query->where('region_id',$region);
            })
            // ->where(['region_from_id' => $user->region_id,'region_to_id' => $user->region_id])
            ->find($id);
        }
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
        $user = $request->user();
        $validator = Validator::make($request->all(), [            
            // 'pass_number'  => 'required|string|unique:directions,pass_number',
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
            'dir_type' => ['required',Rule::in(['bus','taxi']),],
            'cars' => 'nullable|array',
            'cars.*.busmarka_id' => 'nullable|integer',
            'cars.*.busmodel_id' => 'nullable|integer',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        //Check for pass number is unique in the region
        $users_in_region = User::where(['region_id' => $user->region_id,'role_id' => $user->role_id])->pluck('id')->toArray();
        $dir_with_pass_number = Direction::where(['pass_number' => $inputs['pass_number']])->whereIn('created_by',$users_in_region)->first();
        if($dir_with_pass_number){
            return response()->json(['error' => true, 'message' => ' Номер направления занять']);
        }
        //check for bustype_id is equal
        $bus_types = [];
        foreach($inputs['cars'] as $i_car){
            $bus_types[$i_car['bustype_id']] = $i_car['bustype_id'];
        }
        if(count($bus_types) > 1){
            return response()->json(['error' => true, 'message' => 'Категория Авто должно быть одинакова']);
        }
        $direction = Direction::create([
            'pass_number' => $inputs['pass_number'],
            'from_type' => $inputs['from_type'],
            'to_type' => $inputs['to_type'],
            'tarif' => $inputs['tarif'],
            'dir_type' => $inputs['dir_type'],
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
            'created_by' => $user->id,
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
            'pass_number'  => 'required|string|unique:directions,pass_number,'.$direction->id,
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
            'dir_type' => ['required',Rule::in(['bus','taxi']),],
            'cars' => 'nullable|array',
            'cars.*.busmarka_id' => 'nullable|integer',
            'cars.*.busmodel_id' => 'nullable|integer',
            'cars.*.bustype_id' => 'required|integer',
            'cars.*.tclass_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $user = $request->user();
        //Check for pass number is unique in the region
        $users_in_region = User::where(['region_id' => $user->region_id,'role_id' => $user->role_id])->pluck('id')->toArray();
        $dir_with_pass_number = Direction::where(['pass_number' => $inputs['pass_number']])->where('id','!=',$direction->id)->whereIn('created_by',$users_in_region)->first();
        if($dir_with_pass_number){
            return response()->json(['error' => true, 'message' => ' Номер направления занять']);
        }
        //check for bustype_id is equal
        $bus_types = [];
        foreach($inputs['cars'] as $i_car){
            $bus_types[$i_car['bustype_id']] = $i_car['bustype_id'];
        }
        foreach($direction->cars as $d_car){
            $bus_types[$d_car->bustype_id] = $d_car->bustype_id;
        }
        if(count($bus_types) > 1){
            return response()->json(['error' => true, 'message' => 'Категория Авто должно быть одинакова']);
        }
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
            'dir_type' => $inputs['dir_type'],
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
        //Agar yonalish shaxar ichida bosa
        if($direction->type_id == 1){
            $total_result = $this->cityTarif($direction);
        }else{
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
        }
        return response()->json(['success' => true, 'result' => $total_result]);
    }

    //Shahar yonalishlari uchun tarif
    public function cityTarif(Direction $direction)
    {
        $ptimings = $direction->timing->toArray();
        $total_result = [];
        $test = [];
        foreach($direction->regionFrom->tarifcity as $index => $passportTarif){
            $passportTarif = $passportTarif->toArray();
            $summa = $passportTarif['tarif'];
            $summa_bagaj = $passportTarif['tarif_bagaj'];
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
        return $total_result;
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
        $builder = Direction::query()->with(['passport_tarif']);
        $params = $request->all();
        $region = null;
        if(!empty($params['region_id'])){
            $region = $params['region_id'];
            $builder->whereHas('createdBy', function ($query) use ($region){
                $query->where('region_id',$region);
            });
            // $builder->where(['region_from_id' => $params['region_id']])->orWhere(['region_to_id' => $params['region_id']]);
        }
        if(!empty($params['type_id'])){
            $builder->where(['type_id' => $params['type_id']]);
        }
        if(!empty($params['dir_type'])){
            $builder->where(['dir_type' => $params['dir_type']]);
        }
        if(!empty($params['max']) && $params['max'] == true){
            $builder->whereHas('passport_tarif', function ($query) use ($region) {
                return $query->orderBy('summa','DESC');
            });
        }
        if(!empty($params['min']) && $params['min'] == true){
            $builder->whereHas('passport_tarif', function ($query) use ($region) {
                return $query->orderBy('summa','ASC');
            });
        }
        $result = $builder->paginate(20);
        // $result = [];
        // foreach($directions as $key => $dir){
        //     $passport_tarifs = $dir->passport_tarif;
        //     $result[$key] = ['name' => $dir->name,'tarifs' => $passport_tarifs];
        // }
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
                    'bus_order' => !empty($item['bus_order']) ? $item['bus_order'] : null,
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
                    'bus_order' => !empty($to_item['bus_order']) ? $to_item['bus_order'] : null,
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
        $validator = Validator::make($request->all(), [            
            'generate'  => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $tender_lot = TenderLot::whereJsonContains('direction_id', [$direction->id])->first();
        //if generate true recalculate requirement
        if($request->input('generate') == 1){
            if($direction->requirement){
                //Check if direction added to lot
                $tender_lot = TenderLot::whereJsonContains('direction_id',[$direction->id])->first();
                if($tender_lot){
                    return response()->json(['error' => true, 'message' => 'Направление уже используется','result' => $direction->requirement]);
                }
                $direction->requirement->delete();
            }
        }
        if($request->input('generate') == 0 && $direction->requirement){
            return response()->json(['success' => true, 'result' => $direction->requirement]);
        }
        if(count($direction->cars) < 1){
            return response()->json(['error' => true,'message' => 'Пожалуйста, добавьте автомобили в список титулов']);
        }
        if(count($direction->schedule) < 1){
            return response()->json(['error' => true,'message' => 'Пожалуйста, добавьте список расписания']);
        }
        if(count($direction->regionFrom->tarifcity) > 0){
            $tarif_city = $direction->regionFrom->tarifcity->first()->tarif;
        }else{
            $tarif_city = 0;
        }
        $result = [];
        $from_name = $direction->from_where['name'];
        $from_id   = $direction->from_where['id'];
        $to_name   = $direction->timing->last()->whereTo['name'];
        $to_id     = $direction->timing->last()->whereTo['id'];
        $ptimings  = $direction->timing->toArray();
        $reysesFrom = Reys::where(['direction_id' => $id,'type' => 'from','status' => 'active'])->get();
        $reysesTo   = Reys::where(['direction_id' => $id,'type' => 'to','status' => 'active'])->get();
        if(count($reysesTo) < 1 || count($reysesFrom) < 1){
            return response()->json(['error' => true, 'message' => 'Таблица движения не заполнено']);
        }
        //Reys times
        $the_reys_time = array_sum(array_column($ptimings, 'spendtime_between_station')) + array_sum(array_column($ptimings, 'spendtime_to_stay_station'));
        $the_reys_time_hour = $the_reys_time / 60;
        $the_reys_time_minut = ($the_reys_time - (int)$the_reys_time_hour * 60 );
        //remove dublicate classess from direction cars
        // $direction_cars_with = [];
        // foreach($direction->carsWith as $the_car){
        //     $direction_cars_with[$the_car->tclass_id] = $the_car;
        // }
        $data = [
            'direction_id'                  => $direction->id,
            'dir_type'                      => $direction->dir_type,
            'auto_type'                     => $direction->cars->first()->bustype->id,
            'auto_type_name'                => $direction->cars->first()->bustype->name,
            'auto_model_class'              => $direction->carsWith,//->pluck('id'),
            'auto_trans_count'              => $direction->schedule->first()->count_bus,
            'auto_trans_count_from'         => '',
            'auto_trans_count_to'           => '',
            'auto_trans_working_days'       => '',
            'auto_trans_weekends'           => '',
            'auto_trans_status'             => 'Ишлаб чиқарилганига 14 йилдан ошмаган',
            'direction_total_length'        => 0,//$direction->timingWith->last()->distance_from_start_station,
            'direction_from_value'          => $direction->timingWith->last()->distance_from_start_station,
            'direction_from_name'           => $from_name,
            'direction_to_value'            => 0,
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
            'station_intervals'             => '',
            'reys_time'                     => (int)$the_reys_time_hour .':'. $the_reys_time_minut,
            'reys_from_value'               => '00:00',
            'reys_to_value'                 => '00:00',
            'schedules'                     => '-',
            'tarif'                         => $direction->tarif,
            'tarif_one_km'                  => $direction->tarif,
            'tarif_full_km'                  => $direction->getPTarifFull(),
            'tarif_city'                    => $tarif_city,
            'transports_capacity'           => '',
            'transports_seats'              => '',
            'minimum_bal'                   => '',
        ];
        return response()->json(['success' => true, 'result' => $data,'type' => $direction->type]);
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
            // 'auto_model_class' => 'nullable',
            'auto_trans_count' => 'nullable|integer',
            'auto_trans_count_from' => 'nullable|integer',
            'auto_trans_count_to' => 'nullable|integer',
            'auto_trans_working_days' => 'nullable|string',
            'auto_trans_weekends' => 'nullable|string',
            'auto_trans_status' => 'nullable|string',
            'direction_total_length' => 'nullable|numeric',
            'direction_from_value' => 'nullable|numeric',
            'direction_from_name' => 'nullable|string',
            'direction_to_value' => 'nullable|numeric',
            'direction_to_name' => 'nullable|string',
            'stations_count' => 'nullable|integer',
            'stations_from_name' => 'nullable|string',
            'stations_to_name' => 'nullable|string',
            'stations_from_value' => 'nullable|numeric',
            'stations_to_value' =>  'nullable|numeric',
            'seasonal' => 'nullable|string',
            'reyses_count' => 'nullable|integer',
            'reyses_from_value' => 'nullable|integer',
            'reyses_from_name' => 'nullable|string',
            'reyses_to_value' => 'nullable|integer',
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
            'schedules' => 'nullable|integer',
            // 'tarif' => 'nullable|string',
            // 'tarif_one_km' => 'nullable|string',
            // 'tarif_city' => 'nullable|string',
            'transports_capacity' => 'nullable|integer',
            'transports_seats' => 'nullable|integer',
            'minimum_bal' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        //Check if direction added to lot
        $tender_lot = TenderLot::whereJsonContains('direction_id',[$direction->id])->first();
        if($tender_lot){
            return response()->json(['error' => true, 'message' => 'Направление уже используется']);
        }

        $inputs = $request->all();
        $inputs['auto_model_class'] = $direction->carsWith->pluck('id')->toArray();
        $inputs['direction_id'] = $direction->id;
        $inputs['status'] = 'active';

        if(!$direction->requirement){
            $direction_req = DirectionReq::create($inputs);
        }else{
            $direction->requirement->update($inputs);
        }
        return response()->json(['success' => true, 'message' => 'Требование обновлен']);
    }

    public function titul(Request $request)
    {
        $result = Direction::with([
            'regionTo',
            'regionFrom',
            'areaFrom',
            'areaTo',
            'createdBy'
            ])
            ->where(['titul_status' => 'pending'])
            ->orWhere(['titul_status' => 'completed'])
            ->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function titulEdit(Request $request,$id)
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
            'schemaDetails',
        ])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'result' => 'Titul not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function titulActivate(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Titul not found']);
        }
        if($result->titul_status != 'pending'){
            return response()->json(['error' => true, 'message' => 'Titul is '.$result->titul_status]);
        }
        $result->titul_status = 'completed';
        $result->titul_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Titul activated']);
    }
    
    public function titulReject(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Titul not found']);
        }
        $result->titul_status = 'active';
        $result->titul_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Titul rejected']);
    }
    
    public function titulApprove(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Titul not found']);
        }
        if($result->titul_status != 'active'){
            return response()->json(['error' => true, 'message' => 'Titul is '.$result->titul_status]);
        }
        $result->titul_status = 'pending';
        $result->save();
        return response()->json(['success' => true, 'message' => 'Titul successfuly sent for approve']);
    }

    public function xronom(Request $request)
    {
        $result = Direction::with([
            'regionTo',
            'regionFrom',
            'areaFrom',
            'areaTo',
            'createdBy'
            ])
            ->where(['xronom_status' => 'pending'])
            ->orWhere(['xronom_status' => 'completed'])
            ->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function xronomEdit(Request $request,$id)
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
            'schemaDetails',
        ])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Xronometraj not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function xronomActivate(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Xronometraj not found']);
        }
        if($result->xronom_status != 'pending'){
            return response()->json(['error' => true, 'message' => 'Xronometraj is '.$result->xronom_status]);
        }
        $result->xronom_status = 'completed';
        $result->xronom_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Xronometraj activated']);
    }
    
    public function xronomReject(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Xronometraj not found']);
        }
        $result->xronom_status = 'active';
        $result->xronom_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Xronometraj rejected']);
    }

    public function xronomApprove(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Xronometraj not found']);
        }
        if($result->xronom_status != 'active'){
            return response()->json(['error' => true, 'message' => 'Xronometraj is '.$result->xronom_status]);
        }
        $result->xronom_status = 'pending';
        $result->save();
        return response()->json(['success' => true, 'message' => 'Xronometraj successfuly sent for approve']);
    }

    public function sxema(Request $request)
    {
        $result = Direction::with([
            'regionTo',
            'regionFrom',
            'areaFrom',
            'areaTo',
            'createdBy'
            ])
            ->where(['sxema_status' => 'pending'])
            ->orWhere(['sxema_status' => 'completed'])
            ->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function sxemaEdit(Request $request,$id)
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
            'schemaDetails',
        ])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Sxema not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function sxemaActivate(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Sxema not found']);
        }
        if($result->sxema_status != 'pending'){
            return response()->json(['error' => true, 'message' => 'Sxema is '.$result->sxema_status]);
        }
        $result->sxema_status = 'completed';
        $result->sxema_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Sxema activated']);
    }
    
    public function sxemaReject(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Sxema not found']);
        }
        $result->sxema_status = 'active';
        $result->sxema_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Sxema rejected']);
    }

    public function sxemaApprove(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Sxema not found']);
        }
        if($result->sxema_status != 'active'){
            return response()->json(['error' => true, 'message' => 'Sxema is '.$result->sxema_status]);
        }
        $result->sxema_status = 'pending';
        $result->save();
        return response()->json(['success' => true, 'message' => 'Sxema successfuly sent for approve']);
    }

    public function xjadval(Request $request)
    {
        $result = Direction::with([
            'regionTo',
            'regionFrom',
            'areaFrom',
            'areaTo',
            'createdBy'
            ])
            ->where(['xjadval_status' => 'pending'])
            ->orWhere(['xjadval_status' => 'completed'])
            ->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function xjadvalEdit(Request $request,$id)
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
            'schemaDetails',
        ])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Schedule not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function xjadvalActivate(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Schedule not found']);
        }
        if($result->xjadval_status != 'pending'){
            return response()->json(['error' => true, 'message' => 'Schedule is '.$result->xjadval_status]);
        }
        $result->xjadval_status = 'completed';
        $result->xjadval_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Schedule activated']);
    }
    
    public function xjadvalReject(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Schedule not found']);
        }
        $result->xjadval_status = 'active';
        $result->xjadval_approver = $user->id;
        $result->save();
        return response()->json(['success' => true, 'message' => 'Schedule rejected']);
    }

    public function xjadvalApprove(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Schedule not found']);
        }
        if($result->xjadval_status != 'active'){
            return response()->json(['error' => true, 'message' => 'Schedule is '.$result->xjadval_status]);
        }
        $result->xjadval_status = 'pending';
        $result->save();
        return response()->json(['success' => true, 'message' => 'Schedule successfuly sent for approve']);
    }

    public function dirReq(Request $request)
    {
        $result = DirectionReq::with(['type'])
            ->where(['status' => 'pending'])
            ->orWhere(['status' => 'completed'])
            ->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }
    
    public function dirReqEdit(Request $request,$id)
    {
        $result = Direction::with(['type'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Requirement not found']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function dirReqActivate(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Requirement not found']);
        }
        if($result->requirement->status != 'pending'){
            return response()->json(['error' => true, 'message' => 'Requirement is '.$result->requirement->status]);
        }
        $result->requirement->status = 'completed';
        $result->requirement->approver = $user->id;
        $result->requirement->save();
        return response()->json(['success' => true, 'message' => 'Requirement activated']);
    }
    
    public function dirReqReject(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Requirement not found']);
        }
        $result->requirement->status = 'active';
        $result->requirement->approver = $user->id;
        $result->requirement->save();
        return response()->json(['success' => true, 'message' => 'Requirement rejected']);
    }

    public function dirReqApprove(Request $request,$id)
    {
        $user = $request->user();
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Requirement not found']);
        }
        if($result->requirement->status != 'active'){
            return response()->json(['error' => true, 'message' => 'Requirement is '.$result->requirement->status]);
        }
        $result->requirement->status = 'pending';
        $result->requirement->save();
        return response()->json(['success' => true, 'message' => 'Requirement successfuly sent for approve']);
    }

    public function xronomFile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' => 'required|file|mimes:pdf|max:4096',
            'direction_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction = Direction::find($inputs['direction_id']);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Direction not found']);
        }
        //Upload file and image
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('uploads');
            $the_file = $request->file('file');
            $fileName = \Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $input['file'] = '/uploads/'.$fileName;
            $direction->xronom_file = $input['file'];
            $direction->save();
        }
        return response()->json(['success' => true, 'message' => 'File uploaded successfully']);
    }
    
    public function sxemaFile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' => 'required|file|mimes:pdf|max:4096',
            'direction_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction = Direction::find($inputs['direction_id']);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Direction not found']);
        }
        //Upload file and image
        if($request->hasFile('file')){
            $input = [];
            $path = public_path('uploads');
            $the_file = $request->file('file');
            $fileName = \Str::random(20).'.'.$the_file->getClientOriginalExtension();
            $the_file->move($path, $fileName);
            $input['file'] = '/uploads/'.$fileName;
            $direction->sxema_file = $input['file'];
            $direction->save();
        }
        return response()->json(['success' => true, 'message' => 'File uploaded successfully']);
    }
    
}
