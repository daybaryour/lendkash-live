<?php

namespace App\Repositories\Admin;
use App\User;
use App\Models\UserDetail;
use App\Models\RequestLoan;
use App\Models\LoanRequestLender;
use App\Models\Wallet;
use App\Models\LoanEmi;
use App\Models\InvestRequest;
use App\Models\PaymentTransaction;
use App\Models\UnPaidEmi;
use App\Models\Notification;
use DB;

class CronRepository
{
    public function __construct(User $user, UserDetail $userDetail, RequestLoan $requestLoan, LoanRequestLender $lender, InvestRequest $invest, PaymentTransaction $payment, UnPaidEmi $unPaidEmi, Notification $notification) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->requestLoan = $requestLoan;
        $this->lender = $lender;
        $this->invest = $invest;
        $this->payment = $payment;
        $this->unPaidEmi = $unPaidEmi;
        $this->notification = $notification;
    }
    /**
     * Auto Payment Loan EMI
     * @param int
     * @return object
     */
    public static function payLoanEmi() {
        try{
            $currentDate = date("Y-m-d");
            $emiData = LoanEmi::whereDate('emi_date','=', $currentDate)->whereIn('emi_status',['pending','pre_paid'])->get();
            if(!empty($emiData)){
                foreach ($emiData as $key => $value) {
                    DB::beginTransaction();
                    $currentDate = date("Y-m-d H:i:s");
                    // $emiDetail = LoanEmi::where('id', $emiId)->first();
                    $loanId = $value['request_id'];
                    $requestData = RequestLoan::where('id', $loanId)->first();
                    $userInfo = User::where('id', $requestData['user_id'])->first();
                    $lenderData = LoanRequestLender::where('request_id', $requestData['id'])->get();
                    $loanAmount = $requestData['received_amount'];
                    $interestAmount = $requestData['loan_amount_with_interest']-$loanAmount;
                    $adminInterestRate = ($requestData['admin_interest_rate']*100)/$requestData['loan_interest_rate'];

                    $adminTotalCommission = getAdminCommission($interestAmount,$adminInterestRate);
                    // $adminTotalCommission = getAdminCommission($interestAmount,$requestData['admin_interest_rate']);

                    $adminEmiCommission = $adminTotalCommission/$requestData['total_emi'];

                    $adminInfo = getAdminInfo();
                    // Emi distribute to lenders
                    $loanEmi = $requestData['emi_amount']-$adminEmiCommission;
                    // $create = LoanEmi::create(['request_id'=>$loanId,'amount'=>$requestData['emi_amount']]);
                    // $emiCount = LoanEmi::where(['request_id'=>$loanId,'emi_status'=>'paid'])->count();
                    if($userInfo['wallet_balance'] < $requestData['emi_amount'] && $value['emi_status']=='pending')
                    {

                        $emiUpdateData['emi_status'] =  'missed';
                        $update = LoanEmi::where('id',$value['id'])->update($emiUpdateData);

                        $emiCount = LoanEmi::where(['request_id'=>$loanId])->whereIn('emi_status',['paid','pre_paid'])->count();
                        
                        $unPaidData['request_id'] =  $loanId;
                        $unPaidData['emi_id'] =  $value['id'];
                        $unPaidData['emi_number'] =  $emiCount+1;
                        $unPaidData['amount'] =  $requestData['emi_amount'];
                        $update = UnPaidEmi::create($unPaidData);

                        DB::commit();
                    }else{
                        $emiUpdateData['emi_paid_date'] =  $currentDate;
                        $emiUpdateData['emi_status'] =  'paid';
                        $update = LoanEmi::where('id',$value['id'])->update($emiUpdateData);

                        $emiCount = LoanEmi::where(['request_id'=>$loanId])->whereIn('emi_status',['paid','pre_paid'])->count();

                        if($emiCount >= $requestData['total_emi']){
                            $updateData['loan_status'] = 'completed';
                        }
                        $emi_date = strtotime($value['emi_date']);
                        $emiMonth = date('"F"', strtotime($emi_date));
                        if($requestData['payment_frequency']=='monthly'){
                            $nextEmiDate = date("Y-m-d H:i:s", strtotime("+1 month", $emi_date));
                        }else{
                            $nextEmiDate = date("Y-m-d H:i:s", strtotime("+1 week", $emi_date));
                        }
                        $nextEmiId = getNextEmi($loanId);
                        if($nextEmiId){
                            $updateData['next_emi_id'] =  $nextEmiId->id;
                        }

                        $updateData['next_emi_date'] =  $nextEmiDate;
                        $updateData['last_emi_date'] =  $currentDate;
                        $update = RequestLoan::where('id',$loanId)->update($updateData);

                        if($value['emi_status']=='pre_paid'){
                            // Add amount in Admin wallet for hold Lender commission
                            $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$loanId,'transaction_type'=>'lender_hold_amount','payment_type'=>'debit','amount'=>$loanEmi,'comments'=>'Emi amount debited as hold amount for lender on behalf of Request Id '.$loanId];
                            $adminWalletData = addWalletTransaction($adminWalletData);

                             // Notification for Admin
                            $adminNotificationData['request_id']=$loanId;
                            $adminNotificationData['message']= 'Naira '.$loanEmi.' deducted from your wallet on '. $currentDate.' and transferred to '.$userInfo->name.' wallet for '.$emiMonth.'.';
                            $adminNotificationData['to_id']=$adminInfo['id'];
                            $adminNotificationData['from_id']=$userInfo->id;
                            $adminNotificationData['type']=config('constants.notification_type.pay_emi');

                            Notification::create($adminNotificationData);
                        }
                        if(!empty($lenderData)){
                            if($value['emi_status']=='pending'){
                                // Add amount in Admin wallet on behalf of Loan request
                                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'credit','amount'=>$adminEmiCommission,'comments'=>'Emi amount credited on behalf of Request Id '.$loanId];
                                $adminWalletData = addWalletTransaction($adminWalletData);

                                 // Notification for Admin
                                $adminNotificationData['request_id']=$loanId;
                                $adminNotificationData['message']= 'Naira '.$loanEmi.' added in your wallet by '.$userInfo->name.' on '. $currentDate.' for EMI of '.$emiMonth.'.';
                                $adminNotificationData['to_id']=$adminInfo['id'];
                                $adminNotificationData['from_id']=$userInfo->id;
                                $adminNotificationData['type']=config('constants.notification_type.pay_emi');

                                Notification::create($adminNotificationData);

                                // Debit amount from user wallet on behalf of Loan request
                                $userWalletData = ['user_id'=>$requestData['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'debit','amount'=>$requestData['emi_amount'],'comments'=>'Emi amount debited on behalf of Request Id '.$loanId];
                                $userWalletData = addWalletTransaction($userWalletData);
                            }

                            // Add amount in Lenders wallet on behalf of Loan request
                            foreach ($lenderData as $lender) {
                                $lenderEmiCommission = getLenderEmiCommission($loanAmount,$lender['paid_amount'],$loanEmi);
                                $lenderInfo = User::where('id', $lender['user_id'])->first();

                                $lenderWalletData = ['user_id'=>$lender['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'credit','amount'=>$lenderEmiCommission,'comments'=>'Emi amount credited on behalf of Request Id '.$loanId];
                                $lenderWalletData = addWalletTransaction($lenderWalletData);

                                // ************************Email Notifications for lender*******************************
                                    $emailData['email'] = $lenderInfo->email;
                                    $emailData['name'] = $lenderInfo->name;
                                    $emailData['requestId'] = $loanId;
                                    $emailData['type'] = 'lenderEmi';
                                    $emailData['emiAmount'] = round($lenderEmiCommission,2);
                                    $emailData['subject'] = 'EMI for Loan';
                                    sendMails('emails.loan-request', $emailData);
                                // ************************Email Notifications for lender*******************************
                                // ************************Push Notifications for lender*******************************
                                    $lenderIds[]=$lenderInfo->id;
                                    $lenderData['request_id']=$loanId;
                                    $lenderData['message']='Amount of Naira '.$emailData['emiAmount'].' for loan Request ID '.$loanId.' is received in your wallet';
                                    $lenderData['from_id']=$adminInfo['id'];
                                    $lenderData['type']=config('constants.notification_type.receive_emi');
                                    sendPushNotification($lenderData, $lenderIds);
                                // ************************Push Notifications for lender*******************************
                            }

                            // ************************Email Notifications*******************************
                                $emailData['email'] = $userInfo->email;
                                $emailData['name'] = $userInfo->name;
                                $emailData['requestId'] = $loanId;
                                $emailData['type'] = 'userEmi';
                                $emailData['emiAmount'] = round($requestData['emi_amount'],2);
                                $emailData['subject'] = 'EMI for Loan';
                                sendMails('emails.loan-request', $emailData);
                            // ************************Email Notifications*******************************
                            // ************************Push Notifications*******************************
                                $userIds[]=$userInfo->id;
                                $data['request_id']=$loanId;
                                $data['message']='Your EMI for Loan Request ID '.$loanId.' is deducted from your wallet. The amount was Naira '. $emailData['emiAmount'].'.';
                                $data['from_id']=$adminInfo['id'];
                                $data['type']=config('constants.notification_type.pay_emi');
                                sendPushNotification($data, $userIds);
                            // ************************Push Notifications*******************************

                            DB::commit();

                        }else{
                            DB::rollBack();
                            return false;
                        }
                    }
                }
                return 'EMI Paid';
            }else{
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            // DB::rollBack();
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * Check Loan Expiry
     * @param int
     * @return object
     */
    public static function checkLoanRequestExpiry() {
        try{
            $currentDate = date("Y-m-d H:i:s");
            $adminId = getAdminInfo()->id;
            $requestData = RequestLoan::with('user_detail','lender_list')->whereDate('request_expiry_date', '<=', $currentDate)->whereIn('loan_status',['approved','waiting'])->get();
            $arr = [];
            $adminInfo = getAdminInfo();
            if(!empty($requestData)){
                DB::beginTransaction();
                foreach ($requestData as $key => $value) {
                    $userInfo = $value['user_detail'];
                    $loanId = $value['id'];
                    $lenderData = $value['lender_list'];
                    $request_amount = $value['loan_request_amount'];
                    $received_amount = $value['received_amount'];
                    $loanEndDate1 = addDaysInDate($value['loan_term'], 'months');
                    $loanEndDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($loanEndDate1)));
                    if($value['payment_frequency']=='monthly'){
                        $paymentFrequency = 'months';
                        $nextEmiDate = addDaysInDate(1, 'months');
                    }else{
                        $paymentFrequency = 'week';
                        $nextEmiDate = addDaysInDate(1, 'week');
                    }
                    if($received_amount > 0){
                        $arr[] = $value['id'];
                        $receivePercent = receivedAmountPercent($request_amount,$received_amount);
                        if($receivePercent >= 80){
                            $loan_amount_with_interest = amountWithInterest($received_amount, $value['loan_interest_rate'], $value['loan_term']);
                            $emi_amount = $loan_amount_with_interest / $value['total_emi'];

                            $updateData = array(
                                            'next_emi_date'     =>  $nextEmiDate,
                                            'loan_start_date'   =>  $currentDate,
                                            'loan_end_date'     =>  $loanEndDate,
                                            'loan_amount_with_interest'        =>  $loan_amount_with_interest,
                                            'emi_amount'        =>  $emi_amount,
                                            'loan_status'       =>  'active'
                                        );
                            $update = RequestLoan::where('id',$value['id'])->update($updateData);

                            /**============================Insert EMI in Loan EMI table============================== */
                            for ($i=1; $i <= $value['total_emi']; $i++) {
                                $emiData['amount'] = $emi_amount;
                                $emiData['request_id'] = $value['id'];
                                $emiData['emi_date'] = addDaysInDate($i, $paymentFrequency);
                                LoanEmi::create($emiData);
                            }
                            $nextEmiId = getNextEmi($loanId);
                            RequestLoan::where('id',$value['id'])->update(['next_emi_id'=>$nextEmiId->id]);
                            /**============================Credit amount in borrower wallet============================== */
                            $walletDataCredit['user_id'] = $value['user_id'];
                            $walletDataCredit['request_id'] = $value['id'];
                            $walletDataCredit['transaction_type'] = "loan";
                            $walletDataCredit['payment_type'] = "credit";
                            $walletDataCredit['amount'] = $value['received_amount'];
                            $credit = addWalletTransaction($walletDataCredit);

                            // ************************Email Notifications*******************************
                                $emailData['email'] = $userInfo->email;
                                $emailData['name'] = $userInfo->name;
                                $emailData['requestId'] = $value['id'];
                                $emailData['type'] = 'started';
                                $emailData['subject'] = 'Loan request status';
                                sendMails('emails.loan-request', $emailData);

                            // ************************Email Notifications*******************************
                            // ************************Push Notifications*******************************
                                $userIds[]=$userInfo->id;
                                $data['request_id']=$value['id'];
                                $data['message']='Your loan Request ID '.$value['id'].' has started. You can view your loan details in current loan section.';
                                // $data['to_id']=$userInfo->id;
                                $data['from_id']=$adminId;
                                $data['type']=config('constants.notification_type.loan_request_start');
                                // sendPushNotification($data, $userIds);
                            // ************************Push Notifications*******************************
                           
                        }else{

                            if($lenderData){
                                // Add amount in Lenders wallet on behalf of Loan request
                                foreach ($lenderData as $lender) {
                                    /**============================Credit amount in lenders wallet============================== */

                                    $lenderWalletData = ['user_id'=>$lender['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan','payment_type'=>'credit','amount'=>$lender['paid_amount'],'comments'=>'Amount credited on behalf of Request Id '.$loanId.' is expired'];
                                    
                                    addWalletTransaction($lenderWalletData);

                                    // ************************Push Notifications for lender*******************************
                                        $lenderIds[]=$lender['user_id'];
                                        $lenderNotificationData['request_id']=$loanId;
                                        $lenderNotificationData['message']='Amount of Naira '.$lender['paid_amount'].' for loan Request ID '.$loanId.' is returned in your wallet';
                                        $lenderNotificationData['from_id']=$adminInfo['id'];
                                        $lenderNotificationData['type']=config('constants.notification_type.receive_emi');
                                        // sendPushNotification($lenderNotificationData, $lenderIds);
                                    // ************************Push Notifications for lender*******************************
                                }
                            }

                            // ************************Push Notifications*******************************
                                $userIds[]=$userInfo->id;
                                $data['request_id']=$value['id'];
                                $data['message']='Your loan Request ID '.$value['id'].' has expired.';
                                // $data['to_id']=$userInfo->id;
                                $data['from_id']=$adminId;
                                $data['type']=config('constants.notification_type.loan_request_expired');
                                // sendPushNotification($data, $userIds);
                            // ************************Push Notifications*******************************
                            RequestLoan::where('id',$value['id'])->update(['loan_status'=>'expired']);
                        }
                    } else{

                        // ************************Push Notifications*******************************
                            $userIds[]=$userInfo->id;
                            $data['request_id']=$value['id'];
                            $data['message']='Your loan Request ID '.$value['id'].' has expired.';
                            // $data['to_id']=$userInfo->id;
                            $data['from_id']=$adminId;
                            $data['type']=config('constants.notification_type.loan_request_expired');
                            // sendPushNotification($data, $userIds);
                        // ************************Push Notifications*******************************
                        RequestLoan::where('id',$value['id'])->update(['loan_status'=>'expired']);
                    }
                }
                DB::commit();
            }else{
                DB::rollBack();
                return false;
            }
            return $arr;
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    /**
     * Check Invest maturity
     * @param int
     * @return object
     */
    public static function checkInvestMaturity() {
        try{
            DB::beginTransaction();
            $adminId = getAdminInfo()->id;
            $currentDate = date("Y-m-d H:i:s");
            $investData = InvestRequest::whereDate('invest_end_date', '<=', $currentDate)->where('status','approved')->get();
            $arr = [];
            if(!empty($investData) && count($investData)>0){
                foreach ($investData as $key => $value) {
                    $maturity_amount = $value['maturity_amount'];
                    $user_id = $value['user_id'];
                    $userInfo = User::where('id', $user_id)->first();
                    $update = InvestRequest::where('id',$value['id'])->update(['status'=>'completed']);
                    if (!$update) {
                        DB::rollBack();
                        return false;
                    }
                    $adminWalletData = ['user_id'=>$adminId,'request_id'=>$value['id'],'transaction_type'=>'invest','payment_type'=>'debit','amount'=>$maturity_amount,'comments'=>'Your wallet amount debited on behalf of Invest Id '.$value['id']];
                    $updateUserWallet = ['user_id'=>$user_id,'request_id'=>$value['id'],'transaction_type'=>'invest','payment_type'=>'credit','amount'=>$maturity_amount,'comments'=>'Your wallet amount credited on behalf of Invest Id '.$value['id']];
                    $adminWalletData = addWalletTransaction($adminWalletData);
                    $updateUserWallet = addWalletTransaction($updateUserWallet);
                    // ************************Email Notifications*******************************
                        $emailData['email'] = $userInfo->email;
                        $emailData['name'] = $userInfo->name;
                        $emailData['requestId'] = $value['id'];
                        $emailData['type'] = 'investMaturity';
                        $emailData['maturity_amount'] = $maturity_amount;
                        $emailData['subject'] = 'Invest is Matured';
                        sendMails('emails.invest-request', $emailData);
                    // ************************Email Notifications*******************************
                    // ************************Push Notifications*******************************
                        $userIds[]=$userInfo->id;
                        $data['request_id']=$value['id'];
                        $data['message']='Your invest Request Id '.$value['id'].' is matured.';
                        // $data['to_id']=$userInfo->id;
                        $data['from_id']=$adminId;
                        $data['type']=config('constants.notification_type.invest_request_matured');
                        sendPushNotification($data, $userIds);
                    // ************************Push Notifications*******************************
                }
            }
            DB::commit();
            return $arr;
        } catch (\Exception $e) {
            DB::rollBack();
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    
    /**
     * Check Invest maturity
     * @param int
     * @return object
     */
    public static function updateTransferStatus() {
        try{
           
            $adminId = getAdminInfo()->id;
            $currentDate = date("Y-m-d H:i:s");
            $paymentData = PaymentTransaction::where(['payment_status' => 'pending','type' => 'bank_transfer'])->get();
            $arr = [];
            if(!empty($paymentData) && count($paymentData)>0){
                foreach ($paymentData as $key => $value) {
                    DB::beginTransaction();
                    $transaction_id = $value['transaction_id'];
                    $rave_ref = $value['rave_ref'];
                    $secretKey = env('PAYMENT_SECRET_KEY');

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'content-type: application/json'
                    ));
                    // transfer payout status API
                    curl_setopt($ch, CURLOPT_URL, 'https://api.ravepay.co/v2/gpx/transfers?seckey='.$secretKey.'&reference='.$rave_ref.'&id='.$transaction_id);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    $jsonArrayResponse = json_decode($result);
                    $status = $jsonArrayResponse->data->transfers[0]->status;
                    if($status=='SUCCESSFUL'){
                        $update = PaymentTransaction::where('id',$value['id'])->update(['payment_status'=>'successful']);
                        if (!$update) {
                            DB::rollBack();
                            return false;
                        }
                        DB::commit();
                    }
                }
            }
            
            return $arr;
        } catch (\Exception $e) {
            DB::rollBack();
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    public static function checkCrone() {
        // for ($i=1; $i <= 2; $i++) { 
            $lenderWalletData = ['user_id'=>2,'request_id'=>67,'transaction_type'=>'loan','payment_type'=>'credit','amount'=>1000,'comments'=>'Amount credited on behalf of Request Id 67 is expired'];
                                
            addWalletTransaction($lenderWalletData);
        // }

    }
}
