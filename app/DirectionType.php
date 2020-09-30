<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectionType extends Model
{
    protected $fillable = ['name', 'type'];

    public function tclass()
    {
        return $this->hasMany(\App\TClass::class,'bustype_id');
    }

    public function tclasModels()
    {
        $result = $this->tclass()->with('model');
        return $result;
    }
}
