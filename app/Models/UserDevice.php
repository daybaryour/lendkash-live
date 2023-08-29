<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id', 'authorization', 'device_id','device_type', 'certification_type'
    ];

}
