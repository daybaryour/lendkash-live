<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyRequest extends Model
{
    protected $fillable = ['from_id', 'to_id', 'amount', 'status'];


    public function to_user_detail()
    {
        return $this->belongsTo('App\User', 'to_id', 'id')->select(array('id', 'name', 'email', 'mobile_number'));
    }

    public function from_user_detail()
    {
        return $this->belongsTo('App\User', 'from_id', 'id')->select(array('id', 'name', 'email', 'mobile_number'));
    }
}
