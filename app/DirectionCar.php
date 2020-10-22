<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectionCar extends Model
{
    protected $fillable = [
        'busmarka_id',
        'busmodel_id',
        'bustype_id',
        'tclass_id',
        'direction_id'
    ];

    public function marka()
    {
        return $this->belongsTo(\App\BusMarka::class,'busmarka_id');
    }

    public function model()
    {
        return $this->belongsTo(\App\BusModel::class,'busmodel_id');
    }

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'bustype_id');
    }

    public function tclass()
    {
        return $this->belongsTo(\App\TClass::class,'tclass_id');
    }
}
