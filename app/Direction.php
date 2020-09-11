<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['region_from_id','region_to_id','area_from_id','area_to_id','year','distance','type_id','pass_number','station_from_id','station_to_id','name'];

    public function regionFrom()
    {
        return $this->belongsTo(\App\Region::class,'region_from_id');
    }

    public function regionTo()
    {
        return $this->belongsTo(\App\Region::class,'region_to_id');
    }

    public function areaFrom()
    {
        return $this->belongsTo(\App\Area::class,'area_from_id');
    }

    public function areaTo()
    {
        return $this->belongsTo(\App\Area::class,'area_to_id');
    }
}
