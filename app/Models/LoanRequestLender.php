<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanRequestLender extends Model
{
    protected $table = 'loan_request_lenders';
    protected $appends = ['user_name','user_image','rating_flag'];

    protected $fillable = [
        'user_id', 'request_id', 'paid_amount','payment_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function user_detail()
    {
        return $this->belongsTo('App\Models\UserDetail','user_id','user_id');
    }


    public function getUserNameAttribute(){
        $d =  $this->user()->first('name');
        return $d->name;
    }

    public function getUserImageAttribute()
    {
        $d =  $this->user_detail()->first('user_image');
        return checkUserImage($d->user_image,'user_image', $this->role);
    }

    public function loan_detail()
    {
        return $this->belongsTo('App\Models\RequestLoan','request_id','id')->select(array('id','user_id','loan_interest_rate','admin_interest_rate','total_emi','loan_request_amount','received_amount', 'loan_term','payment_frequency','loan_status'));
    }
    public function lender_rating()
    {
        return $this->hasOne('App\Models\Rating','to_id','user_id');
        // return $this->hasOne(
        //     Rating::class,
        //     'to_id',
        //     'user_id'
        // );
    }

    public function getRatingFlagAttribute()
    {
        $d =  $this->lender_rating()->first('id');
        if(!empty($d)){
            return 1;
        }else{
            return 0;
        }

    }

}
