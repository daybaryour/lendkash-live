<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['type', 'from_id', 'to_id', 'request_id', 'message', 'notification_data','is_read'];

}
