<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'direction_ids',
        'time',
        'address',
        'status',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'direction_ids' => 'array'
    ];
}
