<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reys extends Model
{
    protected $fillable = [
        'direction_id',
        'station_id',
        'where',
        'from',
        'stations',
        'where_type',
        'status',
        'user_id',
        'type',
        'count_bus',
        'reys_from_count',
        'reys_to_count',
    ];
    protected $casts = [
        'where' => 'array',
        'from' => 'array',
        'stations' => 'object',
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

    public function reysTimes()
    {
        return $this->hasMany(\App\ReysTime::class,'reys_id')->where(['status' => 'active']);
    }
    
    public function reysPendingTimes()
    {
        return $this->hasMany(\App\ReysTime::class,'reys_id')->where(['status' => 'pending']);
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
