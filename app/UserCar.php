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
        'busmarka_id',
        'capacity',
        'seat_qty',
        'date',
        'conditioner',
        'internet',
        'bio_toilet',
        'bus_adapted',
        'telephone_power',
        'monitor',
        // 'station_announce',
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

    public function busmarka()
    {
        return $this->belongsTo(\App\BusMarka::class,'busmarka_id');
    }

    public function tclass()
    {
        return $this->belongsTo(\App\TClass::class,'tclass_id');
    }

    public function gai()
    {
        return $this->hasMany(\App\GaiCar::class,'pPlateNumber','auto_number');
    }
    
    public function adliya()
    {
        return $this->hasMany(\App\AdliyaCar::class,'pPlateNumber','auto_number');
    }
}
