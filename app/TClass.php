<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TClass extends Model
{
    protected $fillable = ['name','seat_from','seat_to','stay_from','stay_to','busttype_id','busmodel_id'];

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'busttype_id');
    }
}
