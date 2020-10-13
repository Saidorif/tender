<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'app_id',
        'hash',
        'original_name',
        'path',
        'mime_type',
    ];
}
