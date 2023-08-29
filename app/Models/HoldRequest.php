<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoldRequest extends Model
{
    protected $table = 'hold_accept_requests';
    protected $fillable = ['request_id'];


}
