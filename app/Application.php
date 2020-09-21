<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'auto_number',
        'bustype_id',
        'busmodel_id',
        'tclass_id',
        'seat_from',
        'stay_count',
        'tarif',
        'estimated_time',
    ];
}
