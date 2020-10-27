<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Direction;

class Tender extends Model
{
    protected $fillable = [
        'direction_ids',
        'time',
        'address',
        'status',
        'message',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'direction_ids' => 'array'
    ];

    public function tenderlots()
    {
        return $this->hasMany(\App\TenderLot::class,'tender_id');
    }

    // public function tenderlotsWith()
    // {
    //     return $this->tenderlots()->with('directions');
    // }


    public function createdBy()
    {
        return $this->belongsTo(\App\User::class,'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\User::class,'approved_by');
    }

    public function getDirection()
    {
        $result = [];
        foreach ($this->direction_ids as $key => $direction) {
            $result[] = $direction->id;
        }
        return $result;
    }

    public function getDirectionIdsAttribute($value)
    {
        $d_ids = json_decode($value,true);
        // $d_ids = json_decode($d_ids,true);
        $result = [];
        // var_dump(json_decode($d_ids,true));die;
        if(!empty($d_ids)){
            foreach ($d_ids as $key => $id) {
                $direction = Direction::where(['id' => $id])->first();
                $result[] = $direction;
            }
            foreach($result as $key => $value){
                $reysesFrom = Reys::with(['reysTimes'])->where(['direction_id' => $value->id,'type' => 'from'])->get();
                $reysesTo   = Reys::with(['reysTimes'])->where(['direction_id' => $value->id,'type' => 'to'])->get();
                $value->reysesFrom = $reysesFrom;
                $value->reysesTo = $reysesTo;
            };            
        }
        return $result;
    }
}
