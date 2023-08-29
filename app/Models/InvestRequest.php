<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestRequest extends Model
{
    protected $table = 'invests';
    protected $fillable = [
        'user_id', 'invest_amount', 'invests_term', 'interest_rate', 'maturity_amount', 'status', 'invest_start_date', 'invest_end_date'
    ];
    public function user_detail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->select(array('id', 'name', 'email','mobile_number'));
    }
}
