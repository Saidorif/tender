<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name','region_id','area_id','station_type'];

    public function region()
    {
        return $this->belongsTo(\App\Region::class,'region_id');
    }

    public function area()
    {
        return $this->belongsTo(\App\Area::class,'area_id');
    }
}
