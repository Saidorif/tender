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
        'text',
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
    
    public function tender()
    {
        return $this->belongsTo(\App\Tender::class, 'tender_id');
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
            // $reys_ids = Reys::where(['direction_id' => $value->id,'status' => 'active'])->pluck('id')->toArray();
            $reys_ids_from = $reysesFrom->pluck('id')->toArray();
            $reys_ids_to = $reysesTo->pluck('id')->toArray();
            //Compare selected reys_id property with reys_ids array (if in array has selected reyses)
            $reyses_arr_from = array_intersect($this->reys_id,$reys_ids_from);
            $reyses_arr_to = array_intersect($this->reys_id,$reys_ids_to);
            //if reys ids selected set status true else false
            $value->reys_status = [
                'from' => count($reyses_arr_from) ? true : false,
                'to' => count($reyses_arr_to) ? true : false,
            ];
        };
        return $result;
    }
}
