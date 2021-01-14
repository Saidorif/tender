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

    public function apps()
    {
        return $this->hasMany(\App\Application::class, 'lot_id');
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
            $reysesFrom = Reys::with(['reysTimes'])->where(['direction_id' => $value->id,'type' => 'from','status' => 'active'])->get();
            $reysesTo   = Reys::with(['reysTimes'])->where(['direction_id' => $value->id,'type' => 'to','status' => 'active'])->get();
            $value->reysesFrom = $reysesFrom;
            $value->reysesTo = $reysesTo;
            //Get all direction reyses as array
            $reys_ids = Reys::where(['direction_id' => $value->id,'status' => 'active'])->pluck('id')->toArray();
            //Compare selected reys_id property with reys_ids array (if in array has selected reyses)
            $reyses_arr = array_intersect($this->reys_id,$reys_ids);
            //if reys ids selected set status true else false
            $value->reys_status = count($reyses_arr) ? true : false;
        };
        return $result;
    }
}
