<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAccess extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'inn', 'file','status', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
