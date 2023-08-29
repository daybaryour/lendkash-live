<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'request_id', 'from_id', 'to_id', 'rating', 'reviews', 'flag'
    ];

    public function loanRequest()
    {
        return $this->belongsTo('App\Models\RequestLoan','request_id','id');
    }
    public function user_detail()
    {
        return $this->belongsTo('App\User','to_id','id');
    }
}
