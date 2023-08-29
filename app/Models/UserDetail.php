<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'dob', 'user_image','address', 'employer_detail', 'country_id', 'state_id','city_id', 'status', 'is_approved',
        'kyc_status', 'bank_name', 'bvn', 'account_holder_name', 'account_number', 'id_proof_document', 'employment_document', 'wallet_balance'

    ];

    protected $appends = ['name'];


    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function getNameAttribute(){
        $d =  $this->user()->first('name');
        return $d->name;
    }

}
