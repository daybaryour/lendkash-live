<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnPaidEmi extends Model
{
    protected $table = 'unpaid_emis';
    protected $fillable = [
        'request_id', 'emi_id', 'emi_number', 'amount','emi_paid_date','status'
    ];
}
