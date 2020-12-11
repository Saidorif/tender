<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusModel extends Model
{
    protected $fillable = ['name','busbrand_id'];

    public function marka()
    {
        return $this->belongsTo(\App\BusMarka::class,'busbrand_id');
    }
}
