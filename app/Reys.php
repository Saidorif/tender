<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reys extends Model
{
    protected $fillable = [
        'direction_id',
        'station_id',
        'where',
        'where_type',
        'status',
        'user_id',
        'type',
    ];
    protected $casts = [
        'where' => 'array'
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
