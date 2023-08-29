<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LenderRejectRequest extends Model
{
    protected $fillable = [
        'user_id', 'request_id'
    ];
}
