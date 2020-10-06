<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchemaDetail extends Model
{
    protected $fillable = [
        'organ',
        'job',
        'fio',
        'date',
        'direction_id',
    ];
}
