<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimingDetails extends Model
{
    protected $fillable = [
        'direction_id',
        'date',
        'avto_number',
        'avto_model',
        'conclusion',
        'persons',
    ];

    protected $casts = [
        'persons' => 'array',
    ];
}
