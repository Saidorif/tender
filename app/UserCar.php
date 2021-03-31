<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCar extends Model
{
    protected $fillable = [
        'user_id',
        'tender_id',
        'app_id',
        'direction_id',
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
        'station_announce',
        'license_status',
        'license_start_date',
        'license_exp_date',
        'license_number',
        'technical_status',
        'text',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function application()
    {
        return $this->belongsTo(\App\Application::class,'app_id');
    }

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'bustype_id');
    }

    public function busmodel()
    {
        return $this->belongsTo(\App\BusModel::class,'busmodel_id');
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
        return $this->hasOne(\App\GaiCar::class,'pPlateNumber','auto_number');
    }

    public function adliya()
    {
        return $this->hasOne(\App\AdliyaCar::class,'auto_number','auto_number');
    }
}
