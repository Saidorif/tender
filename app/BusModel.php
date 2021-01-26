<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusModel extends Model
{
    // protected $fillable = ['name','busbrand_id'];
    protected $fillable = ['name','seat_from','seat_to','stay_from','stay_to','bustype_id','busmodel_id','busmarka_id','desc'];

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'bustype_id');
    }

    public function model()
    {
        return $this->belongsTo(\App\BusModel::class,'busmodel_id');
    }

    public function marka()
    {
        return $this->belongsTo(\App\BusMarka::class,'busmarka_id');
    }
}
