<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderLot extends Model
{
    protected $fillable = [
        'tender_id',
        'direction_id',
        'reys_id',
        'time',
        'status',
    ];

    protected $casts = [
        'direction_id' => 'array',
        'reys_id'      => 'array'
    ];
}
