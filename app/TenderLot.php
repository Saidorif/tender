<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderLot extends Model
{
    protected $fillable = [
        'tender_id',
        'direction_id',
        'reys_id',
        'time',
        'status',
    ];

    protected $casts = [
        'direction_id' => 'array',
        'reys_id'      => 'array'
    ];

    public function getDirection()
    {
        $result = [];
        foreach ($this->direction_id as $key => $direction) {
            $result[] = $direction->id;
        }
        return $result;
    }

    public function getDirectionIdAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
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
        return $result;
    }
}
