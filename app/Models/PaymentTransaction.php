<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';
    protected $fillable = [
        'user_id', 'transaction_id', 'amount','transaction_ref','transaction_fee','transaction_message','currency','type','account_number','account_bank','bank_name','charged_amount','ip_ref','payment_status','payment_type','payment_id','charge_type','order_ref','rave_ref','logs'
    ];


}
