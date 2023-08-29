<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile_number', 'otp', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['kyc_status','is_approved', 'user_image', 'wallet_balance'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_detail()
    {
        return $this->belongsTo('App\Models\UserDetail','id','user_id');
    }

    public function getKycStatusAttribute(){
        $d =  $this->user_detail()->first('kyc_status');
        return $d->kyc_status;
    }
    public function getWalletBalanceAttribute(){
        $d =  $this->user_detail()->first('wallet_balance');
        return $d->wallet_balance;
    }
    public function getIsApprovedAttribute(){
        $d =  $this->user_detail()->first('is_approved');
        return $d->is_approved;
    }
    // Please ADD this two methods at the end of the class
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [
        'id'        => $this->id,
        'name'      => $this->name,
        'email'      => $this->email,
        'mobile_number' => $this->mobile_number,
        'image_url' => checkUserImage($this->user_detail()->first()->user_image,'user_image', "user"),
        'address' => $this->user_detail()->first()->address,

        ];
    }

    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    public function scopeRole($query, $value)
    {
        return $query->where('role', $value);
    }
    public function userAddress()
    {
        return $this->hasOne('App\Models\UserAddress','user_id','id');
    }
    public function getAddressAttribute()
    {
        $d =  $this->userAddress()->first('address');
        return $d['address'];
    }
    public function getUserImageAttribute()
    {
        $d =  $this->user_detail()->first('user_image');
        return checkUserImage($d->user_image,'user_image', $this->role);
    }
    public function userLoanCount()
    {
        return $this->hasMany('App\Models\RequestLoan','user_id','id');
    }
    public function investLoanCount()
    {
        return $this->hasMany('App\Models\InvestRequest','user_id','id');
    }


    public function from_user()
    {
        return $this->belongsTo('App\Models\MoneyRequest', 'id', 'from_id');
    }

    public function to_user()
    {
        return $this->belongsTo('App\Models\MoneyRequest',  'id', 'to_id');
    }

}
