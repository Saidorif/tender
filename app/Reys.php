<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reys extends Model
{
    protected $fillable = [
        'direction_id',
        'station_id',
        'where_id',
        'where_type',
        'time_from_1',
        'time_from_2',
        'time_from_3',
        'time_from_4',
        'time_to_1',
        'time_to_2',
        'time_to_3',
        'time_to_4',
        'status',
        'user_id',
    ];

    public function region(){
        return $this->belongsTo(\App\Region::class,'station_id');
    }
    public function area(){
        return $this->belongsTo(\App\Area::class,'station_id');
    }
    public function station(){
        return $this->belongsTo(\App\Station::class,'station_id');
    }

    public function scopeGoogle($query)
    {   
        return $query->when($this->where_type === 'region',function($q){
           return $q->with('region');
        })
        ->when($this->where_type === 'area',function($q){
           return $q->with('area');
        })
        ->when($this->where_type === 'station',function($q){
           return $q->with('station');
        });
    }
}
