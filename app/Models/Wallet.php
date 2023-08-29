<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'request_id','emi_id', 'transaction_type','send_money_type', 'payment_type', 'amount', 'comments'];


    public function money_request_detail()
    {
        return $this->belongsTo('App\Models\MoneyRequest', 'request_id', 'id')->select(array('id','to_id','from_id'));
    }

    public function loan_request()
    {
        return $this->belongsTo('App\Models\RequestLoan','request_id','id')->select(array('id','user_id','loan_interest_rate', 'loan_term','loan_status','total_emi','loan_request_amount','loan_description','payment_frequency','received_amount','loan_request_date','created_at','updated_at'));
    }
    public function payment_transaction()
    {
        return $this->belongsTo('App\Models\PaymentTransaction','request_id','id')->select(array('id','user_id', 'transaction_id', 'amount','transaction_message','currency','type','account_number','account_bank','bank_name','payment_status','payment_type'));
    }

}
