<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReysTime extends Model
{
    protected $fillable = [
        'reys_id',
        'direction_id',
        'start',
        'where',
        'status',
        'end',
        'bus_order',
    ];

    protected $casts = [
        'where' => 'array'
    ];
}
