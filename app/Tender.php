<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'direction_ids',
        'type',
        'time',
        'address',
        'status',
        'approved_by',
        'created_by',
    ];
}
