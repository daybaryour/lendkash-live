<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'from_id', 'message', 'inbox_id'
    ];

    public function user_detail()
    {
        return $this->belongsTo('App\User', 'from_id', 'id')->select(array('id', 'name', 'email','mobile_number'));
    }

    public function inbox_detail()
    {
        return $this->belongsTo('App\Models\Inbox', 'inbox_id', 'id')->select(array('id', 'request_id'));
    }


}
