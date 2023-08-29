<?php

namespace App\Repositories;

use App\User;
use JWTAuth;
use JWTAuthException;
use App\Models\UserDevice;
use App\Models\UserAddress;
use DB;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Log;


class UserRepository
{

    public function __construct(User $user, UserDetail $userDetail)
    {
        $this->user = $user;
        $this->userDetail = $userDetail;
    }

    /**
     * User login
     * @param object
     * @return user object
     */
    public function login($request)
    {
        return   $user = $this->user->where('email', $request->email)->where('role', 'user')->with('user_detail')->first();
    }

    /**
     * User registration
     * @param request object
     * @return user object
     */
    public function register($user, $request)
    {

        DB::beginTransaction();
        $userInsert = $this->user->create($user);
        if ($userInsert) {
            $userDetail['user_id'] = $userInsert->id;
            if ($request['user_image']) {
                $userDetail['user_image'] = uploadImage($request['user_image'], "user_image");
            }
            $insert = $this->userDetail->create($userDetail);
            if (!$insert) {
                DB::rollback();
                return false;
            }
        }
        DB::commit();
        return $userInsert;
    }


    /**
     * Send OTP
     * @param object
     * @return user object
     */
    public function sendOTP($request)
    {
        $code = mt_rand(1000, 9999);
        $this->user->where('mobile_number', $request['mobile_number'])->update(['otp' => $code]);
        $user = $this->user->where('mobile_number', $request['mobile_number'])->first();
        return $user;
    }

    /**
     * Send OTP on Email
     * @param object
     * @return user object
     */
    public function sendOTPOnEmail($request)
    {
        $code = mt_rand(1000, 9999);
        $this->user->where('email', $request['email'])->update(['otp' => $code]);
        $user = $this->user->where('email', $request['email'])->first();
        return $user;
    }

    /**
     * check phoneNumber and otp
     * @param object
     * @return user object
     */
    public function checkPhoneNumberOtpExist($request)
    {
        return $this->user->where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->first();
    }

    /**
     * check email
     * @param object
     * @return user object
     */
    public function checkEmailOtpExist($request)
    {
        return $this->user->where('email', $request->email)->where('otp', $request->otp)->first();
    }

    /**
     * Otp verify (mobile number and otp match)
     * @param type $request(OBJ)
     * @return user object
     */
    public function OTPVerify($request)
    {
        $this->user->where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->update(['otp_status' => 'active', 'otp' => null]);
        $user = $this->user->where('mobile_number', $request['mobile_number'])->first();
        return $user;
    }

    /**
     * Otp verify (email and otp match)
     * @param type $request(OBJ)
     * @return user object
     */
    public function OTPEmailVerify($request)
    {
        $this->user->where('email', $request->email)->where('otp', $request->otp)->update(['otp_status' => 'active', 'otp' => null]);
        $user = $this->user->where('email', $request['email'])->first();
        return $user;
    }

    /**
     * Get user
     * @param type $token
     * @return user object
     */
    public function getAuthUser($token)
    {
        $user = JWTAuth::authenticate($token);
        return $user;
    }



    /**
     * Change password
     * @param Request $request
     * @return boolean
     */
    public function changePassword($request)
    {
        return $this->user->where('id', $request->user()->id)
            ->update(array('password' => bcrypt($request['new_password'])));
    }



    /**
     * Reset password
     * @param type $request
     * @return boolean
     */
    public function resetPassword($request)
    {
        return $this->user->where('password_token', '=', $request['code'])
            ->update(array('password' => bcrypt($request['password']), 'password_token' => null));
    }


    /**
     * check phoneNumber
     * @param object
     * @return user object
     */
    public function checkPhoneNumberExist($request)
    {
        return $this->user->where(['mobile_number'=> $request['mobile_number'], 'status'=>'active', 'otp_status'=>'active'])->with('user_detail')->first();
    }

     /**
     * check phone Number exist for send opt
     * @param object
     * @return user object
     */
    public function checkPhoneNumberForOtp($request)
    {
        return $this->user->where(['mobile_number'=> $request['mobile_number']])->first();
    }

    /**
     * check email
     * @param object
     * @return user object
     */
    public function checkEmailExist($request)
    {
        $user = $this->user->where('email', $request['email'])->first();
        return $user;
    }

    /**
     * Update password
     * @param type array
     * @return boolean
     */
    public function updatePassword($data)
    {
        return $this->user->where('password_token', '=', $data['token'])
            ->update(array('password' => bcrypt($data['password']), 'password_token' => null));
    }

    public function checkAlreadyApproved($userId)
    {
        return $this->userDetail->where('user_id', $userId)->where('is_approved', 1)->first();
    }


    /**
     * Check user exist
     * @param type int
     * @return object
     */
    public function checkUserExist($userId)
    {
        return $this->user->where(['id' => $userId, 'status' => 'active', 'otp_status' => 'active'])->with('user_detail')->first();
    }
    /**
     * Complete user KYC detail
     *  @param  array
     * @return boolean
     */
    public function completeKycDetail($request, $userAuth, $userId)
    {
        $this->user->where('id', $userId)->update($userAuth);
        return $this->userDetail->where('user_id', $userId)->update($request);
    }

    /**
     * Get KYC detail
     * @param  int
     * @return object
     */
    public function getKycDetail($userId)
    {
        return $this->userDetail->where('user_id', $userId)->first();
    }
    /*
     * update profile
     * @return object
     */
    public function updateProfile($data, $userId)
    {
        $this->user->where('id', $userId)->update(['name'=>$data['name']]);
        if($data['user_image']){
            return $this->userDetail->where('user_id', '=', $userId)
            ->update(array('user_image' => $data['user_image'], 'address' => $data['address']));
        }
        return $this->userDetail->where('user_id', '=', $userId)
            ->update(array('address' => $data['address']));
    }
}
