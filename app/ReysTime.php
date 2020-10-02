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
        'end'
    ];

    protected $casts = [
        'where' => 'array'
    ];
}
