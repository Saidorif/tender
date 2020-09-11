<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TClass extends Model
{
    protected $fillable = ['name','seat_from','seat_to','stay_from','stay_to'];
}
