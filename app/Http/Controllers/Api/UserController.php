<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginValidation;
use App\Http\Requests\Api\OtpVerifyValidation;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Repositories\UserRepository;
use JWTAuth;
use JWTAuthException;
use App\Country;
use App\Http\Requests\Api\ChangePasswordValidation;
use App\Http\Requests\Api\CompleteKycValidation;
use App\Http\Requests\Api\RegistrationValidation;
use App\Models\Notification;
use App\Models\UserDevice;
use App\Repositories\InvestRepository;
use DB;

class UserController extends Controller
{

    public function __construct(UserRepository $user, UserDevice $userDevice, InvestRepository $invest)
    {
        $this->user = $user;
        $this->userDevice = $userDevice;
        $this->invest = $invest;
    }


    public function sendNotification(){
        try {
            $userIds[]=  120;
            $data['request_id']=null;
            $data['message']='test message';
            $data['to_id']='120';
            $data['from_id']='120';
            $data['type']='test';
            return sendTestPushNotification($data, $userIds);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' =>  $e->getMessage()]]);
        }
    }
    /**
     * Login
     * @param object
     * @return object
     */
    public function login(LoginValidation $request)
    {
        try {
            DB::beginTransaction();
            $credentials = $request->only('email', 'password');
            $token = null;
            $userDetail = $this->user->login($request);
            if (!$userDetail) {
                return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_cred')]], 400);
            }
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_cred')]], 400);
            }
            if ($userDetail['otp_status'] == "inactive") {
                return response()->json(['success' => true, 'error' => ['message' => __('api.account_not_verify')], "is_otp_verified" => 0], 422);
            }
            if ($userDetail['status']=="inactive") {
                return response()->json(['success' => false, 'error' => ['message' => __('api.account_inactive_by_admin')]], 422);
            }
            $userInfo['authorization'] = $token;
            $userInfo['message'] = __("api.login_successful");
            $request['token'] = $token;
            $userInfo['is_kyc_submitted'] = $userDetail['user_detail']['kyc_status'];
            $userInfo['is_kyc_approved'] = $userDetail['user_detail']['is_approved'];
            $request['user_id'] = $userDetail->id;
            $userInfo['status'] = $userDetail->status;

            //=====================update user device details=================
            UserDevice::where('user_id', $userDetail['id'])->delete();
            $userDevice['authorization'] = $token;
            $userDevice['device_id'] = $request['device_id'];
            $userDevice['device_type'] = $request['device_type'];
            $userDevice['user_id'] = $userDetail['id'];
            $userDevice['certification_type'] = $request['certification_type'];
            $addData = $this->userDevice->create($userDevice);
            if (!$addData) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => trans('common.user_not_updated')]);
            }
            //=====================update user device details end=================

            DB::commit();
            return response()->json(['success' => true, 'error' => [], 'data' => $userInfo]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => ['message' =>  $e->getMessage()]]);
        }
    }


    /**
     * Register
     * @param  object
     * @return object
     */
    public function register(RegistrationValidation $request)
    {
        try {
            $otp = mt_rand(1000, 9999);
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['mobile_number'] = $request->mobile_number;
            $data['password'] = bcrypt($request->password);
            $data['otp'] = $otp;
            $result = $this->user->register($data, $request);
            if ($result) {
                $emailData['otp'] = $result['otp'];
                $emailData['email'] = $request->email;
                $emailData['name'] = $request->name;
                $emailData['mobile_number'] = $request->mobile_number;
                $emailData['subject'] = 'Account verification';

                if (!sendMails('emails.account-verification', $emailData)) {
                    return response()->json(['success' => false, 'error' => ['message' => __('api.register_success_mail_not_sent')]], 422);
                }
                $body = "Your four digit verification code is ".$otp." Please verify your email and start exploring Lendkash";
                sendSms('+234'.$request->mobile_number,$body);

                return response()->json(['success' => true, 'error' => [], 'data' => ['message' => __('api.register_successful'), 'otp' => $result['otp']]]);
            } else {
                return response()->json(['success' => false, 'error' => ['message' => __('api.user_not_create')]], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Send OTP
     * @param Request $request
     * @return type
     */
    public function sendOTP(Request $request)
    {
        if (!empty($request['mobile_number']) || !empty($request['email'])) {
            if (!empty($request['mobile_number'])) {
                try {
                    $check_user = $this->user->checkPhoneNumberForOtp($request);
                    if (!$check_user) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_phone_number')]], 400);
                    }
                    if ($check_user['status'] == "inactive") {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.account_inactive_by_admin'), "is_approved" => 0]], 422);
                    }
                    $sendOtp = $this->user->sendOTP($request);
                    if (!$sendOtp) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.OTP_not_send')]], 422);
                    }

                    if ($sendOtp) {
                        $emailData['otp'] = $sendOtp['otp'];
                        $emailData['email'] = $check_user['email'];
                        $emailData['name'] = $sendOtp['name'];
                        $emailData['subject'] = 'Account verification';
                    }
                    if (!sendMails('emails.account-verification', $emailData)) {
                        return response()->json(['success' => false, 'error' => ['message' => __("api.mail_not_send")]], 422);
                    }
                    $body = "Your four digit verification code is ".$sendOtp['otp']." Please verify your email and start exploring Lendkash";

                    sendSms($request->mobile_number,$body);

                    return response()->json(['success' => true, 'error' => [], 'data' => [
                        'message' => __('api.OTP_send_successful'),
                        'mobile_number' => $sendOtp['mobile_number'],
                        'otp' => $sendOtp['otp']
                    ]]);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
                }
            } else {
                try {
                    $checkEmail = $this->user->checkEmailExist($request);
                    if (!$checkEmail) {
                        return response()->json(['success' => false, 'error' => ['message' => __("api.invalid_email")]], 422);
                    }
                    $sendOtp = $this->user->sendOTPOnEmail($request);
                    if ($sendOtp) {
                        $emailData['otp'] = $sendOtp['otp'];
                        $emailData['email'] = $sendOtp['email'];
                        $emailData['name'] = $sendOtp['name'];
                        $emailData['subject'] = 'Account verification';
                    }
                    if (!sendMails('emails.account-verification', $emailData)) {

                        return response()->json(['success' => false, 'error' => ['message' => __("api.mail_not_send")]], 422);
                    }
                    $body = "Your four digit verification code is ".$sendOtp['otp']." Please verify your email and start exploring Lendkash";

                    sendSms($request->mobile_number,$body);
                    return response()->json(['success' => true, 'error' => [], 'data' => ['message' => __("api.check_mail_for_verify_account"), 'activation_code' => $sendOtp['otp']]]);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
                }
            }
        } else {
            return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_email_phone_number')]], 400);
        }
    }

    /**
     * OTP and mobile verification .
     * @param type $request(OBJ)
     * @return type Json
     */
    public function OTPVerify(OtpVerifyValidation $request)
    {
        if (!empty($request['mobile_number']) || !empty($request['email'])) {
            if ($request['mobile_number']) {
                try {
                    $check_user = $this->user->checkPhoneNumberOtpExist($request);
                    if (!$check_user) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_otp')]], 400);
                    }
                    $OTPVerify = $this->user->OTPVerify($request);
                    if (!$OTPVerify) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.OTP_verification_failed')]], 200);
                    }
                    if (!$userToken = JWTAuth::fromUser($OTPVerify)) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.OTP_verification_failed')]], 400);
                    }
                    $request['token'] = $userToken;
                    $request['user_id'] = $OTPVerify['id'];
                    self::insertDeviceDetails($request['token'], $request);
                    return response()->json(['success' => true, 'error' => [], 'data' => ['authorization' => $userToken]]);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
                }
            } else {
                try {
                    $checkEmail = $this->user->checkEmailOtpExist($request);
                    if (!$checkEmail) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_otp')]], 400);
                    }
                    $OTPEmailVerify = $this->user->OTPEmailVerify($request);
                    if (!$OTPEmailVerify) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.OTP_verification_failed')]], 200);
                    }
                    if (!$userToken = JWTAuth::fromUser($OTPEmailVerify)) {
                        return response()->json(['success' => false, 'error' => ['message' => __('api.OTP_verification_failed')]], 400);
                    }
                    $request['token'] = $userToken;
                    $request['user_id'] = $OTPEmailVerify->id;
                    self::insertDeviceDetails($request['token'], $request);

                    return response()->json(['success' => true, 'error' => [], 'data' => ['authorization' => $userToken]]);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
                }
            }
        } else {
            return response()->json(['success' => false, 'error' => ['message' => __('api.invalid_email_phone_number')]], 400);
        }
        return $this->user->OTPVerify($request);
    }

    /**
     * Insert device details
     */
    public function insertDeviceDetails($userToken, $request)
    {
        //=====================update user device details=================

        $userDevice['authorization'] = $userToken;
        $userDevice['device_id'] = $request['device_id'];
        $userDevice['device_type'] = $request['device_type'];
        $userDevice['user_id'] = $request['user_id'];
        $userDevice['certification_type'] = $request['certification_type'];
        $addData = $this->userDevice->create($userDevice);
        if (!$addData) {
            return response()->json(['success' => false, 'data' => [], 'message' => trans('common.user_not_updated')]);
        }

        //=====================update user device details end=================
    }
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmailApi($email)
    {
        try {
            if ($email) {
                $checkEmail = findEmail($email, 'user');

                if ($checkEmail) {
                    $saveToken = saveToken($email);
                    $checkEmail['code'] = $saveToken;
                    $checkEmail['email'] = $email;
                    $checkEmail['subject'] = "Forgot Password Mail";

                    if (sendMails('emails.forgot_password', $checkEmail)) {
                        return response()->json(['success' => true, 'error' => [], 'data' => ['message' => __("api.verification_code_send")]]);
                    } else {
                        return response()->json(['success' => false, 'error' => ['message' => __("common.mail_not_sent")]], 422);
                    }
                } else {
                    return response()->json(['success' => false, 'error' => ['message' => __("api.email_not_exist")]], 422);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    /**
     * Reset password
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordApi(Request $request)
    {
        $checkCode = checkToken($request['code']);
        if (!$checkCode) {
            return response()->json(['success' => false, 'data' => [], 'message' => __('api.invalid_otp')]);
        }
        $changePassword = $this->user->resetPassword($request);
        if (!$changePassword) {
            return response()->json(['success' => false, 'data' => [], 'message' => __('common.password_not_changed')]);
        }
        return response()->json(['success' => true, 'data' => [], 'message' => __('common.password_changed')]);
    }

    /**
     * Country list
     * @return array
     */
    public function getCountryList()
    {
        $countries = getCountryList();
        return response()->json(['success' => true, 'error' => [], 'data' => $countries]);
    }

    /**
     * States list
     *  @param  int country id
     * @return array
     */
    public function getStateList($countryId)
    {
        $states = getStateList($countryId);
        return response()->json(['success' => true, 'error' => [], 'data' => $states]);
    }
    /**
     * City list
     *  @param  int state id
     * @return array
     */
    public function getCityList($stateId)
    {
        $cities = getCityList($stateId);
        return response()->json(['success' => true, 'error' => [], 'data' => $cities]);
    }

    /**
     * Complete user KYC detail
     *  @param  object
     * @return boolean
     */
    public function completeKycDetail(CompleteKycValidation $request)
    {
        try {
            $adminInfo=getAdminInfo();
            $userId = $request['user']['id'];
            $checkApproved = $this->user->checkAlreadyApproved($userId);
            if ($checkApproved) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.account_already_approved')]);
            }
            $userAuth['name'] = $request['name'];
            $data['dob'] = $request['dob'];
            $data['address'] = $request['address'];
            $data['employer_detail'] = $request['employer_detail'];
            $data['country_id'] = $request['country_id'];
            $data['city_id'] = $request['city_id'];
            $data['state_id'] = $request['state_id'];
            $data['kyc_status'] = 1;
            $data['bank_name'] = $request['bank_name'];
            $data['bvn'] = $request['bvn'];
            $data['account_holder_name'] = $request['account_holder_name'];
            $data['account_number'] = $request['account_number'];
            if ($request->file('id_proof_document')) {
                $data['id_proof_document'] = uploadImage($request['id_proof_document'], "user_document");
            }
            if ($request->file('employment_document')) {
                $data['employment_document'] = uploadImage($request['employment_document'], "user_document");
            }
            $insert = $this->user->completeKycDetail($data, $userAuth,  $userId);
            if (!$insert) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.KYC_detail_not_added')]);
            }
            // ************************Push Notifications******************************
            $userIds[]=$userId;
            $data['request_id']=null;
            $data['message']=config('constants.notification_messages.kyc_notification');
            $data['to_id']=$userId;
            $data['from_id']=$adminInfo->id;
            $data['type']=config('constants.notification_type.kyc_verification');
            sendPushNotification($data, $userIds);
           // ************************Push Notifications*******************************

            // ************************Admin Notifications*******************************
                // $userIdsData[]=$adminInfo->id;
                $dataAdmin['request_id']=null;
                $dataAdmin['message']=config('constants.notification_messages.approve_kyc');
                $dataAdmin['to_id']=$adminInfo->id;
                $dataAdmin['from_id']=$userId;
                $dataAdmin['type']=config('constants.notification_type.approve_kyc');
                Notification::create($dataAdmin);

                $responseData['dob'] = $request['dob'];
                $responseData['address'] = $request['address'];
                $responseData['employer_detail'] = $request['employer_detail'];
                $responseData['country_id'] = $request['country_id'];
                $responseData['bank_name'] = $request['bank_name'];
                $responseData['bvn'] = $request['bvn'];
                $responseData['account_holder_name'] = $request['account_holder_name'];
                $responseData['account_number'] = $request['account_number'];
            // ************************Admin Notifications end******************************

            return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.KYC_detail_added')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Get KYC detail
     *  @param  int
     * @return object
     */
    public function getKycDetail(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $details = $this->user->getKycDetail($userId);
            $details['id_proof_document_type'] = pathinfo($details['id_proof_document'], PATHINFO_EXTENSION);
            $details['employment_document_type'] = pathinfo($details['employment_document'], PATHINFO_EXTENSION);
            $details['id_proof_document'] = getUploadedImage($details['id_proof_document'], "user_document");
            $details['employment_document'] = getUploadedImage($details['employment_document'], "user_document");
            $details['country_name'] = getCountryName($details['country_id']);
            $details['state_name'] = getStateName($details['state_id']);
            $details['city_name'] = getCityName($details['city_id']);
            return response()->json(['success' => true, 'error' => [], 'data' => $details]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Change password
     * @param type $request
     * @return type
     */
    public function changePassword(ChangePasswordValidation $request)
    {
        try {
            if (!\Hash::check($request['current_password'], $request->user()->password)) {

                return response()->json(['success' => false, 'data' => [], 'message' => __('common.old_password_not_match')], 422);
            }
            $update = $this->user->changePassword($request);
            if (!$update) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('common.password_not_changed')], 500);
            }
            return response()->json(['success' => true, 'data' => [], 'message' => __('common.password_changed')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get wallet balance
     * @return object
     */
    public function userSetting(Request $request)
    {
        try {
            $data['wallet_balance'] = $request['user']['wallet_balance'];
            $data['is_kyc_approved'] = $request['user']['is_approved'];
            $data['status'] = $request['user']['status'];
            $data['chat_count']=Notification::where(['to_id'=> $request['user']['id'], 'is_read'=>"0", 'type'=>'new_message_receive'])->count();
            $data['all_count']=Notification::where(['to_id'=> $request['user']['id'], 'is_read'=>"0"])->where('type','<>','new_message_receive')->count();
            $data['PAYMENT_PUBLIC_KEY']=env('PAYMENT_PUBLIC_KEY');
            $data['PAYMENT_SECRET_KEY']=env('PAYMENT_SECRET_KEY');
            $data['PAYMENT_ENCRYPTION_KEY']=env('PAYMENT_ENCRYPTION_KEY');
            $data['OKRA_PUBLIC_KEY']=env('OKRA_PUBLIC_KEY');
            $data['OKRA_TOKEN']=env('OKRA_TOKEN');
            $data['OKRA_ENV']=env('OKRA_ENV');
            $invests=$this->invest->checkUserInvest($request['user']['id']);
            if($invests){
                $data['is_invest']=true;
            } else {
                $data['is_invest']=false;

            }
            return response()->json(['success' => true, 'error' => [], 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Logout user
     * @param null
     * @return type
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate();
            $this->userDevice->where('user_id', $request['user']['id'])->update(['authorization' => '','device_id' => '']);

            return response()->json(['success' => true, 'data' => [], 'message' => __("api.logout_successful")]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * update profile
     * @param object
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $userId = $request['user']['id'];
            $userDetail = getUserDetailByUserId($userId);
            $data['name'] = $request['name'];
            $data['address'] = $request['address'];
            if ($request->file('user_image')) {
                $data['user_image'] = uploadImage($request['user_image'], "user_image");
            } else {
                $data['user_image'] = $userDetail['user_image'];
            }

            $update = $this->user->updateProfile($data, $userId);
            if (!$update) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.user_profile_not_update')]);
            }
            $userInfo['user_id'] = $userId;
            $userInfo['name'] = $request['name'];
            $userInfo['address'] = $request['address'];
            $userInfo['mobile_number'] = $request['user']['mobile_number'];
            $userInfo['email'] = $request['user']['email'];
            if ($request->file('user_image')) {
                $userInfo['user_image'] = getUploadedImage($data['user_image'], "user_image");
            } else {
                $userInfo['user_image'] = $request['user']['user_image'];
            }
            $userInfo['wallet_balance'] = $request['user']['wallet_balance'];
            return response()->json(['success' => true, 'data' => $userInfo, 'message' => __('api.user_profile_updated')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
