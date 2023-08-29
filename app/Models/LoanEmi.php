<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanEmi extends Model
{
    protected $table = 'loan_emis';
    protected $fillable = [
        'request_id', 'amount','emi_date','emi_status'
    ];
}
