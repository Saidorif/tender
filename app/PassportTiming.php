<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassportTiming extends Model
{
    protected $fillable = [
        'direction_id',
        'region_from_id',
        'region_to_id',
        'area_from_id',
        'area_to_id',
        'station_from_id',
        'station_to_id',
        'start_time',
        'end_time',
        'start_speedometer',
        'end_speedometer',
        'distance_from_start_station',
        'distance_between_station',
        'distance_in_limited_speed',
        'spendtime_between_station',
        'spendtime_between_limited_space',
        'spendtime_to_stay_station',
        'speed_between_station',
        'speed_between_limited_space',
        'details',
        'whereForm',
        'whereTo',
        'vars',
        // 'timingDetails',
    ];

    protected $casts = [
        'whereForm' => 'array',
        'whereTo' => 'array',
        'details' => 'array',
        'vars' => 'array',
    ];

    public function regionFrom()
    {
        return $this->belongsTo(\App\Region::class,'region_from_id');
    }

    public function regionTo()
    {
        return $this->belongsTo(\App\Region::class,'region_to_id');
    }

    public function areaFrom()
    {
        return $this->belongsTo(\App\Area::class,'area_from_id');
    }

    public function areaTo()
    {
        return $this->belongsTo(\App\Area::class,'area_to_id');
    }

    public function stationFrom()
    {
        return $this->belongsTo(\App\Station::class,'station_from_id');
    }

    public function stationTo()
    {
        return $this->belongsTo(\App\Station::class,'station_to_id');
    }

    public function getDetailsAttribute($value)
    {
        $details = json_decode($value);
        foreach($details as $k => $value){
            if(is_integer($value->name)){
                $c_sign = ConditionalSign::find($value->name);
                if($c_sign){
                    $value->sign = $c_sign;
                }
            }
        }
        return $details;
    }
}
