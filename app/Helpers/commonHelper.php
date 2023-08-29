<?php

use App\Models\City;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserDevice;
use App\Models\Country;
use App\Models\State;
use App\Models\LoanEmi;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\UserDetail;
use App\Models\RequestLoan;
use App\Models\Wallet;
use App\Models\MoneyRequest;
use App\Models\PaymentTransaction;
use Twilio\Rest\Client;
/**
 * Save token
 */
function saveToken($email)
{
    $token = mt_rand(1000, 9999);
    $response = User::where('email', '=', $email)->update(array('password_token' => $token));
    if ($response) {
        return $token;
    } else {
        return false;
    }
}

/**
 * Save token link
 */
function saveTokenLink($email)
{
    $token = hash_hmac('sha256', str_random(40) . time(), config('app.key'));
    $response = User::where('email', '=', $email)->update(array('password_token' => $token));
    if ($response) {
        return $token;
    } else {
        return false;
    }
}

/**
 *Check token
 */
function checkToken($token)
{
    $response = User::where('password_token', '=', $token)->first();
    if ($response) {
        return true;
    } else {
        return false;
    }
}

/**
 * Find email with role
 */
function findEmail($email, $role)
{
    $response = User::where('email', '=', $email)->where('role', '=', $role)->where('status', "active")
        ->first();
    if ($response) {
        return $response;
    } else {
        return false;
    }
}

/**
 * Update password
 */
function updatePassword($data)
{
    $response = User::where('password_token', '=', $data['code'])
        ->update(array('password' => bcrypt($data['password']), 'password_token' => null));
    if ($response) {
        return true;
    } else {
        return false;
    }
}



/**
 * Invalid token
 */
function invalidToken($userId)
{
    try {
        $checkUser = UserDevice::where('user_id', $userId)->first();
        $removeToken = UserDevice::where('user_id', $userId)->update(['authorization' => '', 'device_id' => '']);
        if (!empty($checkUser['authorization'])) {
            JWTAuth::invalidate($checkUser['authorization']);
        }
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * Update user wallet balance
 */
function updateUserBalance($amount, $userId, $type)
{
    if ($type == 'add') {
        return UserDetail::where('user_id',  $userId)->update(['wallet_balance' => DB::raw('wallet_balance + ' . $amount)]);
    } else {
        if ($type == 'minus') {
            return UserDetail::where('user_id',  $userId)->update(['wallet_balance' => DB::raw('wallet_balance - ' . $amount)]);
        }
    }
}

/**
 * Update user wallet history
 */
function addWalletTransaction($data)
{
    if ($data['payment_type'] == 'debit') {
        updateUserBalance($data['amount'], $data['user_id'], 'minus');
    }else{
        updateUserBalance($data['amount'], $data['user_id'], 'add');
    }
    $res = Wallet::create($data);
    return $res;
}

/**
 * Sum of EMI amount received for lender
 */
function emiAmountReceived($requestId, $userId)
{

    return Wallet::where(['user_id' => $userId, 'request_id' => $requestId, 'transaction_type' => 'loan_emi', 'payment_type' => 'credit'])->sum('amount');
}

/**
 * EMI amount received for lender
 */
function emiAmountReceivedHistory($requestId, $userId)
{

    return Wallet::where(['user_id' => $userId, 'request_id' => $requestId, 'transaction_type' => 'loan_emi', 'payment_type' => 'credit'])->latest("id")->get();
}

function getUserInfo($type)
{
    $userData = User::where('id', auth()->guard($type)->user()->id)->first();
    return $userData;
}

function getAdminInfo()
{
    return User::where('role', 'admin')->first();
}


/**
 * Get country list
 */
function getCountryList()
{
    $response = Country::get();
    if ($response) {
        return $response;
    } else {
        return false;
    }
}

/**
 * Get country list
 */
function getStateList($countryId)
{
    $response = State::where('country_id', $countryId)->get();
    if ($response) {
        return $response;
    } else {
        return false;
    }
}

/**
 * Get country list
 */
function getCityList($stateId)
{
    $response = City::where('state_id', $stateId)->get();
    if ($response) {
        return $response;
    } else {
        return false;
    }
}

/**
 * Get country name
 */
function getCountryName($cid)
{
    $response = Country::where('id', $cid)->first();
    if ($response) {
        return $response->name;
    } else {
        return false;
    }
}
/**
 * Get country name
 */
function getStateName($sid)
{
    $response = State::where('id', $sid)->first();
    if ($response) {
        return $response->name;
    } else {
        return false;
    }
}
/**
 * Get city name
 */
function getCityName($cityId)
{
    $response = City::where('id', $cityId)->first();
    if ($response) {
        return $response->name;
    } else {
        return false;
    }
}
/**
 * Get paid EMI Count
 * @param type int
 * @return type  int
 */
function getPaidEmi($requestId)
{
    $response = LoanEmi::where(['request_id'=> $requestId])->whereIn('emi_status',['paid','pre_paid'])->count();
    if ($response) {
        return $response;
    } else {
        return 0;
    }
}

/**
 * Get term by id
 */
function getTermById($termId)
{
    $setting = Setting::where('id', $termId)->first();
    if (!$setting) {
        return 0;
    }
    if ($setting['type'] == 'one_month_admin_loan_commission') {
        return 1;
    }
    if ($setting['type'] == 'three_month_admin_loan_commission') {
        return 3;
    }
    if ($setting['type'] == 'six_month_admin_loan_commission') {
        return 6;
    }
    if ($setting['type'] == 'twelve_month_admin_loan_commission') {
        return 12;
    }
    if ($setting['type'] == 'six_month_interest') {
        return 6;
    }
    if ($setting['type'] == 'twelve_month_interest') {
        return 12;
    }
}
/**
 * Get invest interest
 */
function getInvestInterest($termId)
{
    $setting = Setting::where('id', $termId)->first();
    return $setting['value'];
}

function remainingDaysFromTwoDate($startDate, $endDate)
{
    // Calculating the difference in timestamps
    $diff = strtotime($endDate) - strtotime($startDate);
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}


//Get avg of user rating.
function getAvgRating($rating_array)
{

    if (count($rating_array) > 0) {
        $total = count($rating_array);
        $rat = 0;
        foreach ($rating_array as $rating) {
            $rat += $rating['rating'];
        }
        return number_format($rat / $total, 1);
    }
}
//Get user name by loan request id.
function getUserNameByRequestId($requestId)
{
    $userName = RequestLoan::where('id', $requestId)->first();
    return $userName->user_name;
}
//Get user name by user id.
function getUserNameByUserId($userId)
{
    $userName = User::where('id', $userId)->first();
    if($userName){
        return $userName->name;
    }else{
        return $userId;
    }
}
//Get user name by user id.
function getUserDetailByUserId($userId)
{
    $userDetail = UserDetail::where('user_id', $userId)->first();
    return $userDetail;
}
//Get user name by user id.
function receivedRequestStatus($id)
{
    $data = MoneyRequest::where(['id' => $id, 'status' => 'paid'])->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}
//Get To User Name by user id.
function getToUserName($data)
{
    $type = $data['transaction_type'];
    $payment_type = $data['payment_type'];
    if($type=='loan_emi'){
        if($payment_type=='credit'){
            return getUserNameByUserId($data['user_id']);
        }else{
            $loanDetail = RequestLoan::where('id',$data['request_id'])->first();
            return getUserNameByUserId($loanDetail['user_id']);
        }
    }
    else if($type=='loan'){
        if($payment_type=='credit'){
            return getUserNameByUserId($data['user_id']);
        }else{
            return "By Admin";
        }
    }
    else if($type=='add_money'){
        return getUserNameByUserId($data['user_id']);
    }
    else if($type=='bank_transfer'){
        $paymentDetail = PaymentTransaction::where('id',$data['request_id'])->first();
        return $paymentDetail['account_number']." (Bank)";
    }
    else if($type=='wallet'){
        $moneyRequest = MoneyRequest::where('id',$data['request_id'])->first();
        return getUserNameByUserId($moneyRequest['to_id']);
    }
    else if($type=='invest'){
        if($payment_type=='credit'){
            return getUserNameByUserId($data['user_id']);
        }else{
            return "By Admin";
        }
    }
    else{
        return $type;
    }
}
//Get From User Name by user id.
function getFromUserName($data)
{
    $type = $data['transaction_type'];
    $payment_type = $data['payment_type'];
    if($type=='loan_emi'){
        if($payment_type=='credit'){
            $loanDetail = RequestLoan::where('id',$data['request_id'])->first();
            return getUserNameByUserId($loanDetail['user_id']);
        }else{
            return getUserNameByUserId($data['user_id']);
        }
    }
    else if($type=='loan'){
        if($payment_type=='credit'){
            return "By Admin";
        }else{
            return getUserNameByUserId($data['user_id']);
        }
    }
    else if($type=='add_money'){
        $paymentDetail = PaymentTransaction::where('id',$data['request_id'])->first();
        if($paymentDetail['payment_type']=='card'){
            return "From Card";
        }else{
            return "From Bank";
        }
    }
    else if($type=='bank_transfer'){
        return getUserNameByUserId($data['user_id'])." (Wallet)";
    }
    else if($type=='invest'){
        if($payment_type=='credit'){
            return "By Admin";
        }else{
            return getUserNameByUserId($data['user_id']);
        }
    }
    else if($type=='wallet'){
        $moneyRequest = MoneyRequest::where('id',$data['request_id'])->first();
        return getUserNameByUserId($moneyRequest['from_id']);
    }
    else{
        return $type;
    }
}


function sendPushNotification($data, $userIds)
{
    if (count($userIds) > 0) {
        foreach ($userIds as $id) {
            $insertNotification['to_id'] = $id;
            $insertNotification['from_id'] = $data['from_id'];
            $insertNotification['type'] = $data['type'];
            if ($data['type'] == "new_message_receive") {
                $insertNotification['request_id'] = $data['inbox_id'];
                $inbox_id = $data['inbox_id'];
            } else {
                $insertNotification['request_id'] = $data['request_id'];
                $inbox_id = "";
            }
            $insertNotification['message'] = $data['message'];
            $insertNotification['notification_data'] = json_encode($data);
            Notification::create($insertNotification);
            $data['badge_count'] = 1;
            $data['title'] = "Lendkash";

            $data['all_count'] = 1;
            $data['chat_count'] = 1;
            $userDevice = UserDevice::where('user_id', $id)->first();

            $deviceId = [$userDevice['device_id']];
            $API_ACCESS_KEY = getenv("API_ACCESS_KEY");
            if (!isset($API_ACCESS_KEY)) {
                return false;
            }
            $badgeCount = Notification::where(['to_id' => $id,'is_read' => 0])->count();

            $url = 'https://fcm.googleapis.com/fcm/send';
            if($userDevice['device_type'] == 'ios') {
                $fields = array('registration_ids' => $deviceId,'notification' => array('sound' => 'default','body' => $data['message'],"priority" => "high","contentAvailable"=>true,'data' => array('message' => $data['message'], 'type' => $data['type'],'badge_count' => $badgeCount,'title' => $data['title'],'inbox_id'=>$inbox_id,'request_id'=>$data['request_id'])));
            } else {
                $fields = array('registration_ids' => $deviceId,'data' => array('message' => $data['message'], 'type' => $data['type'],'badge_count' => $badgeCount,'title' => $data['title'],'inbox_id'=>$inbox_id,'request_id'=>$data['request_id']),"priority" => "high");
            }

            $headers = array(
                'Authorization: key='.$API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            $result = json_decode($result,TRUE);
            Log::debug('notification check', ['data' => $result]);
            return $result;
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            if ($result['success'] == 1) {
                curl_close($ch);
            } else {
                curl_close($ch);
            }

        }
    }
}

function sendTestPushNotification($data, $userIds)
{
    if (count($userIds) > 0) {
        foreach ($userIds as $id) {
            $insertNotification['to_id'] = $id;
            $insertNotification['from_id'] = $data['from_id'];
            $insertNotification['type'] = $data['type'];
            if ($data['type'] == "new_message_receive") {
                $insertNotification['request_id'] = $data['inbox_id'];
            } else {
                $insertNotification['request_id'] = $data['request_id'];
            }
            $insertNotification['message'] = $data['message'];
            $insertNotification['notification_data'] = json_encode($data);
            Notification::create($insertNotification);
            $data['badge_count'] = 1;
            $data['title'] = "Lendkash";

            $data['all_count'] = 1;
            $data['chat_count'] = 1;
            $userDevice = UserDevice::where('user_id', $id)->first();
            // return $userDevice['device_id'];

            $deviceId = [$userDevice['device_id']];
            $messages =  'Test Message';
            $API_ACCESS_KEY = getenv("API_ACCESS_KEY");
            if (!isset($API_ACCESS_KEY)) {
                return false;
            }
            $badgeCount = Notification::where(['to_id' => $id,'is_read' => 0])->count();


            $url = 'https://fcm.googleapis.com/fcm/send';
            if($userDevice['device_type'] == 'ios') {
                $fields = array('registration_ids' => $deviceId,'notification' => array('sound' => 'default','body' => $data['message'],"priority" => "high","contentAvailable"=>true,'data' => array('message' => $data['message'], 'type' => $data['type'],'badge_count' => $badgeCount,'title' => $data['title'])));
            } else {
                $fields = array('registration_ids' => $deviceId,'data' => array('message' => $data['message'], 'type' => $data['type'],'badge_count' => $badgeCount,'title' => $data['title']),"priority" => "high");
            }
            $headers = array(
                'Authorization: key='.$API_ACCESS_KEY,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            $result = json_decode($result,TRUE);
            Log::debug('notification check', ['data' => $result]);
            return $result;
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            if ($result['success'] == 1) {
                curl_close($ch);
            } else {
                curl_close($ch);
            }

        }
    }
}

/**
 * Transfer amount admin wallet to Bank account
 */
function createBankTransfer($request,$transferAmount)
{
    $ref = rand(4,9999);
    $postData =  array(
        'account_bank' => $request->bank_code,
        'account_number' => $request->account_number,
        'amount' => $transferAmount,
        'seckey' => env('PAYMENT_SECRET_KEY'),
        'narration' => 'new amount transfer',
        'currency' => 'NGN',
        'reference' => 'ref-'.$ref,
        'beneficiary_name' => $request->beneficiary_name,
    );

    $ch = curl_init();
    $url = "https://api.ravepay.co/v2/gpx/transfers/create";
    // $url = "https://ravesandboxapi.flutterwave.com/v2/gpx/transfers/create";

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postData));  //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
    'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $request = curl_exec ($ch);
    $err = curl_error($ch);

    if($err){
        // there was an error contacting rave
        die('Curl returned error: ' . $err);
    }


    curl_close ($ch);

    $result = json_decode($request, true);
    return $result;
    // echo "<pre>";
    // print_r($result);
    // die();
}
/**
 * Transfer amount admin wallet to Bank account
 */
function bankTransfer($data)
{
    $ref = rand(4,9999);
    $postData =  array(
        'account_bank' => $data['bank_code'],
        'account_number' => $data['account_number'],
        'amount' => $data['transferAmount'],
        'seckey' => env('PAYMENT_SECRET_KEY'),
        'narration' => 'new amount transfer',
        'currency' => 'NGN',
        'reference' => 'ref-45'.$ref,
        'beneficiary_name' => $data['beneficiary_name'],
    );

    $ch = curl_init();
    $url = "https://api.ravepay.co/v2/gpx/transfers/create";
    // $url = "https://ravesandboxapi.flutterwave.com/v2/gpx/transfers/create";

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postData));  //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
    'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $request = curl_exec ($ch);
    $err = curl_error($ch);

    if($err){
        // there was an error contacting rave
    die('Curl returned error: ' . $err);
    }


    curl_close ($ch);

    $result = json_decode($request, true);
    return $result;
    // echo "<pre>";
    // print_r($result);
    // die();
}


/**
 * GEt Next EMI
 *  @param  object
 * @return id
 */
function getNextEmi($loanId)
{
    return  LoanEmi::where(['request_id'=>$loanId,'emi_status'=>'pending'])->first();
}
/**
 * Send SMS
 */
function sendSms($number, $body)
{
    $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
    $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
    $appSid     = config('app.twilio')['TWILIO_APP_SID'];
    $client = new Client($accountSid, $authToken);
    // Use the client to do fun stuff like send text messages!
    $client->messages->create(
        // the number you'd like to send the message to
        $number,
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => 'Lendkash',
            // the body of the text message you'd like to send
            'body' => $body
        )
    );

    return true;
}
