<?php

namespace App\Http\Controllers;

use App\Direction;
use App\Reys;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function requirement(Request $request,$id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        if(!$direction->requirement){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        return response()->json(['success' => true, 'result' => $direction->requirement,'type' => $direction->type]);
    }

    public function directionEdit(Request $request, $id)
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
            'createdBy',
        ])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
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
                    //$result[$i][$key]['ddd'] = 0;
                    if($key != 0 && $i != 0){
                        //$result[$i][$key]['ddd'] += round($timing['distance_between_station'],2);
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

    public function getSchedule(Request $request, $id)
    {
        $result = [
            'whereFrom' => [],
            'whereTo' => [],
        ];
        $reysesFrom = Reys::with(['reysTimes'])->where(['direction_id' => $id,'type' => 'from','status' => 'active'])->get();
        $reysesTo   = Reys::with(['reysTimes'])->where(['direction_id' => $id,'type' => 'to','status' => 'active'])->get();

        foreach ($reysesFrom as $key => $reys_from) {
            $result['whereFrom'][] = $reys_from;
        }
        foreach ($reysesTo as $reys_to) {
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
}
