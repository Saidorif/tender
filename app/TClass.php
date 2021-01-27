<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TClass extends Model
{
    protected $fillable = ['name','bustype_id'];

    public function bustype()
    {
        return $this->belongsTo(\App\BusType::class,'bustype_id');
    }
}
