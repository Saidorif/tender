<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'app_id',
        'type',
        'car_id',
        'file',
    ];
}
