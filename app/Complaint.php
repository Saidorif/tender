<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'middlename',
        'phone',
        'text',
        'comment',
        'comment_file',
        'file',
        'status',
        'direction_id',
        'region_id',
        'area_id',
        'user_id',
        'category_id',
    ];

    public function direction()
    {
        return $this->belongsTo(\App\Direction::class,'direction_id');
    }
}
