<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appfile extends Model
{
    protected $fillable = [
        'app_id',
        'type',
        'car_id',
        'file',
    ];
}
