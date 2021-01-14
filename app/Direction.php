<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['region_from_id','moderator','region_to_id','area_from_id','area_to_id','year','distance','type_id','pass_number','station_from_id','station_to_id','name','seasonal','from_where','profitability','tarif','from_type','to_type','created_by'];

    protected $casts = ['from_where' => 'array'];

    public function regionFrom()
    {
        return $this->belongsTo(\App\Region::class,'region_from_id');
    }

    public function regionFromWith()
    {
        return $this->regionFrom()->with(['area']);
    }

    public function regionTo()
    {
        return $this->belongsTo(\App\Region::class,'region_to_id');
    }

    public function regionToWith()
    {
        return $this->regionTo()->with(['area']);
    }

    public function areaFrom()
    {
        return $this->belongsTo(\App\Area::class,'area_from_id');
    }

    public function areaFromWith()
    {
        return $this->areaFrom()->with(['station']);
    }

    public function areaTo()
    {
        return $this->belongsTo(\App\Area::class,'area_to_id');
    }

    public function type()
    {
        return $this->belongsTo(\App\DirectionType::class,'type_id');
    }

    public function areaToWith()
    {
        return $this->areaTo()->with(['station']);
    }

    public function timing()
    {
        return $this->hasMany(\App\PassportTiming::class,'direction_id');
    }

    public function timingDetails()
    {
        return $this->hasMany(\App\TimingDetails::class,'direction_id');
    }

    public function timingWith()
    {
        return $this->timing()->with(['regionFrom','regionTo','areaFrom','areaTo','stationFrom','stationTo']);
    }

    public function schedule()
    {
        return $this->hasMany(\App\Reys::class,'direction_id')->where(['status' => 'active']);
    }

    public function schemaDetails()
    {
        return $this->hasMany(\App\SchemaDetail::class,'direction_id');
    }
    public function tenderlots()
    {
        return $this->hasMany(\App\TenderLot::class,'direction_id');
    }

    public function stationFrom()
    {
        return $this->belongsTo(\App\Station::class,'station_from_id');
    }
    public function stationTo()
    {
        return $this->belongsTo(\App\Station::class,'station_to_id');
    }

    public function cars()
    {
        return $this->hasMany(\App\DirectionCar::class,'direction_id');
    }

    public function carsWith()
    {
        return $this->cars()->with(['model','marka','bustype','tclass']);
    }

    public function requirement()
    {
        return $this->hasOne(\App\DirectionReq::class,'direction_id')->with(['type']);
    }
    
    public function passport_tarif()
    {
        return $this->hasMany(\App\PassportTarif::class,'direction_id');
    }
    
    public function getPTarifFull()
    {
        return \App\PassportTiming::where(['direction_id' => $this->id])->get()->last()->distance_from_start_station * $this->tarif;
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class,'created_by');
    }
    
    public function getModeratorAttribute()
    {
        return $this->createdBy->region->name;
    }
    
}
