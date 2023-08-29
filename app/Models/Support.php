<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';
    protected $fillable = [
        'request_id', 'user_id', 'title','description'
    ];

    // protected $appends = ['email'];


    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // public function getEmailAttribute(){
    //     $d =  $this->user()->first('email');
    //     return $d->email;
    // }
}
