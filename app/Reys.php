<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reys extends Model
{
    protected $fillable = [
        'direction_id',
        'station_id',
        'where_id',
        'time_from_1',
        'time_from_2',
        'time_from_3',
        'time_from_4',
        'time_to_1',
        'time_to_2',
        'time_to_3',
        'time_to_4',
    ];
}
