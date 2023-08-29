<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLoan extends Model
{
    protected $table = 'loan_requests';
    protected $appends = ['rating', 'user_name', 'mobile_number', 'user_image'];
    protected $fillable = [
        'user_id', 'loan_interest_rate', 'loan_term','okra_log', 'total_emi', 'loan_request_amount', 'admin_interest_rate', 'loan_description', 'loan_status', 'loan_cancelled_reason', 'received_amount',
        'payment_frequency', 'loan_request_date', 'request_expiry_date', 'loan_start_date', 'loan_end_date', 'loan_amount_with_interest', 'last_emi_date', 'next_emi_date','next_emi_id', 'emi_amount'

    ];

    public function avg_rating_review()
    {
        return $this->hasMany('App\Models\Rating', 'to_id', 'user_id')
            ->selectRaw('to_id, AVG(ratings.rating) AS average_rating')->where('flag',0)
            ->groupBy('to_id');
    }


    public function getRatingAttribute()
    {
        $d =  $this->avg_rating_review()->first();
        if ($d) {
            return $d->average_rating;
        }
        return 0;
    }


    public function user_detail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->select(array('id', 'name', 'email', 'mobile_number'));
    }
    public function user_kyc_detail()
    {
        return $this->belongsTo('App\Models\UserDetail', 'user_id', 'user_id')->select(array('id', 'is_approved', 'kyc_status','user_image'));
    }

    public function inbox_detail()
    {
        return $this->hasOne('App\Models\Inbox', 'request_id', 'id')->select(array('id', 'request_id'));
    }

    public function lender_list()
    {
        return $this->hasMany('App\Models\LoanRequestLender', 'request_id', 'id')->latest('id');
    }

    public function emi_list()
    {
        return $this->hasMany('App\Models\LoanEmi', 'request_id', 'id');
    }
    public function getUserNameAttribute()
    {
        $d =  $this->user_detail()->first();
        return $d->name;
    }
    public function getMobileNumberAttribute()
    {
        $d =  $this->user_detail()->first('mobile_number');
        return $d->mobile_number;
    }
    public function getUserImageAttribute()
    {
        $d =  $this->user_kyc_detail()->first('user_image');
        return checkUserImage($d->user_image, 'user_image', $this->role);
    }
}
