<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $table = 'bank_details';
    protected $fillable = [
        'user_id', 'bank_name','bank_code', 'bvn','account_holder_name','account_number'
    ];


}
