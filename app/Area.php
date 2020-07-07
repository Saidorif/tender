<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Region;
class Area extends Model
{
    protected $fillable = ['name','region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }
}
