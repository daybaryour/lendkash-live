<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserDetail;
use App\Models\RequestLoan;
use App\Models\LoanRequestLender;
use App\Models\Wallet;
use App\Models\LoanEmi;
use App\Models\InvestRequest;
use App\Models\UnPaidEmi;
use DB;


class LoanRepository {

    public function __construct(User $user, UserDetail $userDetail, RequestLoan $requestLoan, LoanRequestLender $lender, InvestRequest $invest, UnPaidEmi $unPaidEmi) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->requestLoan = $requestLoan;
        $this->lender = $lender;
        $this->invest = $invest;
        $this->unPaidEmi = $unPaidEmi;

    }
    /**
     * Load user loan request
     * @param int
     * @return object
     */
    public function approvalLoans($request) {
        if (request()->ajax()) {
            $sql = $this->requestLoan->with('user_detail')->where('loan_status','pending');
            if (!empty($request->loanRequestId)) {
                $sql->where('id', $request->loanRequestId);
            }
            if (!empty($request->loanInterest)) {
                $sql->where('loan_interest_rate',$request->loanInterest);
            }
            if (!empty($request->loanTerm)) {
                $sql->where('loan_term',$request->loanTerm);
            }
            if (!empty($request->paymentFrequency)) {
                $sql->where('payment_frequency',$request->paymentFrequency);
            }
            if (!empty($request->LoanEMI)) {
                $sql->where('emi_amount','=',$request->LoanEMI);
            }
            if (!empty($request->loanAmount)) {
                $sql->where('loan_request_amount','=',$request->loanAmount);
            }
            return $sql->latest('id')->get();
        }
    }
    /**
     * Update Loan Status
     * @param int
     * @return object
     */
    public function updateLoanStatus($id,$status) {
        try{
            $model = $this->requestLoan->where('id', $id)->first();
            $userInfo = $this->user->where('id', $model['user_id'])->first();
            $adminId = getAdminInfo()->id;
            if($model){
                $model->loan_status = $status;
                if($status=='approved'){
                    $model->request_expiry_date =  addDaysInDate("14", "days");
                }
                if($model->save()){
                    // ************************Email Notifications*******************************
                        $emailData['email'] = $userInfo->email;
                        $emailData['name'] = $userInfo->name;
                        $emailData['requestId'] = $id;
                        $emailData['type'] = 'status';
                        $emailData['status'] = $status;
                        $emailData['subject'] = 'Loan request status';
                        sendMails('emails.loan-request', $emailData);
                    // ************************Email Notifications*******************************
                    // ************************Push Notifications*******************************
                        $userIds[]=$userInfo->id;
                        $data['request_id']=$id;
                        $data['message']='Your loan Request Id '.$id.' is '.$status.' by Admin';
                        // $data['to_id']=$userInfo->id;
                        $data['from_id']=$adminId;
                        $data['type']=config('constants.notification_type.loan_request_'.$status.'');
                        sendPushNotification($data, $userIds);
                    // ************************Push Notifications*******************************
                    return json_encode(array('success' => true, 'message' => 'Loan request  '.$status.' successfully!'));
                }else{
                    return json_encode(array('success' => false, 'message' => 'Please try again'));
                }
            }else{
                return json_encode(array('success' => false, 'message' => 'Please try again'));
            }

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    /**
     * Auto Payment Loan EMI
     * @param int
     * @return object
     */
    public function payMissedLoanEmi($emiId) {
        try{
            $emiId = $emiId;
            $emiData = LoanEmi::where('id',$emiId)->first();
            DB::beginTransaction();
            $currentDate = date("Y-m-d H:i:s");
            $loanId = $emiData['request_id'];
            $requestData = RequestLoan::where('id', $loanId)->first();
            $okraData = json_decode($requestData->okra_log);
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

            $emiUpdateData['emi_paid_date'] =  $currentDate;
            $emiUpdateData['emi_status'] =  'paid';
            $update = LoanEmi::where('id',$emiData['id'])->update($emiUpdateData);

            $emiCount = LoanEmi::where(['request_id'=>$loanId])->whereIn('emi_status',['paid','pre_paid'])->count();
            // Update Unpaid table data
            UnPaidEmi::where('emi_id',$emiData['id'])->update(['status'=>'paid','emi_paid_date'=>$currentDate]);
            if($emiCount >= $requestData['total_emi']){
                $updateData['loan_status'] = 'completed';
            }
            $emi_date = strtotime($emiData['emi_date']);
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

           
            if(!empty($lenderData)){
                
                // Add amount in Admin wallet on behalf of Loan request
                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'credit','amount'=>$adminEmiCommission,'comments'=>'Emi amount credited on behalf of Request Id '.$loanId];
                $adminWalletData = addWalletTransaction($adminWalletData);

                // Debit amount from user wallet on behalf of Loan request
                $userWalletData = ['user_id'=>$requestData['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'debit','amount'=>$requestData['emi_amount'],'comments'=>'Emi amount debited on behalf of Request Id '.$loanId];
                $userWalletData = addWalletTransaction($userWalletData);

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
                        $lenderNotificationData['request_id']=$loanId;
                        $lenderNotificationData['message']='Amount of Naira '.$emailData['emiAmount'].' for loan Request ID '.$loanId.' is received in your wallet';
                        $lenderNotificationData['from_id']=$adminInfo['id'];
                        $lenderNotificationData['type']=config('constants.notification_type.receive_emi');
                        sendPushNotification($lenderNotificationData, $lenderIds);
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
                return json_encode(array('success' => true, 'message' => 'EMI paid successfully!'));

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
    public function checkLoanRequestExpiry() {
        try{
            $currentDate = date("Y-m-d H:i:s");
            $adminId = getAdminInfo()->id;
            $requestData = $this->requestLoan->with('user_detail','lender_list')->whereDate('request_expiry_date', '<=', $currentDate)->whereIn('loan_status',['approved','waiting'])->get();
            $arr = [];
            $adminInfo = getAdminInfo();
            foreach ($requestData as $key => $value) {
                // $userInfo = $this->user->where('id', $value['user_id'])->first();
                $userInfo = $value['user_detail'];
                $loanId = $value['id'];
                // $lenderData = LoanRequestLender::where('request_id', $value['id'])->get();
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
                        $update = $this->requestLoan->where('id',$value['id'])->update($updateData);

                        /**============================Insert EMI in Loan EMI table============================== */
                        for ($i=1; $i <= $value['total_emi']; $i++) {
                            $emiData['amount'] = $emi_amount;
                            $emiData['request_id'] = $value['id'];
                            $emiData['emi_date'] = addDaysInDate($i, $paymentFrequency);
                            LoanEmi::create($emiData);
                        }
                        $nextEmiId = getNextEmi($loanId);
                        $this->requestLoan->where('id',$value['id'])->update(['next_emi_id'=>$nextEmiId->id]);
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

                                $lenderInfo = $this->user->where('id', $lender['user_id'])->first();

                                /**============================Credit amount in lenders wallet============================== */

                                $lenderWalletData = ['user_id'=>$lender['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan','payment_type'=>'credit','amount'=>$lender['paid_amount'],'comments'=>'Amount credited on behalf of Request Id '.$loanId.' is expired'];

                                addWalletTransaction($lenderWalletData);

                                // ************************Push Notifications for lender*******************************
                                    $lenderIds[]=$lenderInfo->id;
                                    $lenderNotificationData['request_id']=$loanId;
                                    $lenderNotificationData['message']='Amount of Naira '.$lender['paid_amount'].' for loan Request ID '.$loanId.' is returned in your wallet';
                                    $lenderNotificationData['from_id']=$adminInfo['id'];
                                    $lenderNotificationData['type']=config('constants.notification_type.receive_emi');
                                    // sendPushNotification($lenderData, $lenderIds);
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
                        $this->requestLoan->where('id',$value['id'])->update(['loan_status'=>'expired']);
                    }
                } else{
                    if($lenderData){
                        // Add amount in Lenders wallet on behalf of Loan request
                        foreach ($lenderData as $lender) {

                            $lenderInfo = $this->user->where('id', $lender['user_id'])->first();

                            /**============================Credit amount in lenders wallet============================== */

                            $lenderWalletData = ['user_id'=>$lender['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan','payment_type'=>'credit','amount'=>$lender['paid_amount'],'comments'=>'Amount credited on behalf of Request Id '.$loanId.' is expired'];
                            $lenderWalletData = addWalletTransaction($lenderWalletData);

                            // ************************Push Notifications for lender*******************************
                                $lenderIds[]=$lenderInfo->id;
                                $lenderData['request_id']=$loanId;
                                $lenderData['message']='Amount of Naira '.$lender['paid_amount'].' for loan Request ID '.$loanId.' is returned in your wallet';
                                $lenderData['from_id']=$adminInfo['id'];
                                $lenderData['type']=config('constants.notification_type.receive_emi');
                                // sendPushNotification($lenderData, $lenderIds);
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
                    $this->requestLoan->where('id',$value['id'])->update(['loan_status'=>'expired']);
                }
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
    public function checkInvestMaturity() {
        try{
            DB::beginTransaction();
            $adminId = getAdminInfo()->id;
            $currentDate = date("Y-m-d H:i:s");
            $investData = $this->invest->whereDate('invest_end_date', '<=', $currentDate)->where('status','approved')->get();
            $arr = [];
            if(!empty($investData) && count($investData)>0){
                foreach ($investData as $key => $value) {
                    $maturity_amount = $value['maturity_amount'];
                    $user_id = $value['user_id'];
                    $userInfo = $this->user->where('id', $user_id)->first();
                    $update = $this->invest->where('id',$value['id'])->update(['status'=>'completed']);
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
     * Load user loan request
     * @param int
     * @return object
     */
    public function unPaidEmiList($request) {
        if (request()->ajax()) {
            $sql = $this->unPaidEmi->select('unpaid_emis.*','users.name as user_name','loan_emis.emi_date');

            $sql->join('loan_emis', 'loan_emis.id' , '=', 'unpaid_emis.emi_id');
            $sql->join('loan_requests', 'loan_requests.id' , '=', 'unpaid_emis.request_id');
            $sql->join('users', 'users.id' , '=', 'loan_requests.user_id');
            if (!empty($request->requestId)) {
                $sql->where('unpaid_emis.request_id', $request->requestId);
            }
            if (!empty($request->userName)) {
                $sql->having('user_name',$request->userName);
            }
            return $sql->latest('id')->get();
        }
    }
}
