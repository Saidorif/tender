<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TarifCity extends Model
{
    protected $fillable = ['region_id','tarif','tarif_bagaj','status','file'];

    public function region()
    {
        return $this->belongsTo(\App\Region::class,'region_id');
    }
}
