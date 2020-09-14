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
    ];
}
