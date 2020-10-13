<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCar extends Model
{
    protected $fillable = [
        'user_id',
        'tender_id',
        'app_id',
        'status',
        'auto_number',
        'bustype_id',
        'busmodel_id',
        'tclass_id',
        'qty_reys',
        'capacity',
        'seat_qty',
        'date',
        'conditioner',
        'internet',
        'bio_toilet',
        'bus_adapted',
        'telephone_power',
        'monitor',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'bustype_id');
    }

    public function busmodel()
    {
        return $this->belongsTo(\App\BUsModel::class,'busmodel_id');
    }

    public function tclass()
    {
        return $this->belongsTo(\App\TClass::class,'tclass_id');
    }
}
