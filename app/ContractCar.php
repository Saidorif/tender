<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractCar extends Model
{
    protected $fillable = [
        'auto_number',
        'bustype_id',
        'busmodel_id',
        'tclass_id',
        'busmarka_id',
        'user_id',
        'contract_id',
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

    public function contract()
    {
        return $this->belongsTo(\App\Contract::class,'contract_id');
    }
}
