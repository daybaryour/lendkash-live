<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankMaster extends Model
{
    protected $table = 'bank_masters';
    protected $fillable = [
        'bank_code', 'name','status'
    ];


}
