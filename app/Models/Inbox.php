<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $fillable = [
        'request_id', 'user_id', 'type', 'message'
    ];


    public function group_members() {
        return $this->hasMany('App\Models\GroupMember', 'inbox_id', 'id');
    }


}
