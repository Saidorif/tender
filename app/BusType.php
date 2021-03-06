<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    protected $fillable = ['name','desc'];

    public function tclass()
    {
        return $this->hasMany(\App\TClass::class,'bustype_id');
    }
}
