<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = [
        'region_id',
        'created_by',
        'number',
        'date',
        'file'
    ];
}
