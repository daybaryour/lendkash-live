<?php

namespace App\Repositories;

use App\Models\RequestLoan;
use App\Models\LenderRejectRequest;
use App\Models\LoanRequestLender;
use App\Models\Setting;
use App\Models\HoldRequest;
use App\Models\LoanEmi;
use App\Models\Notification;
use App\User;
use DB;

class LoanRepository
{

    public function __construct(RequestLoan $loan, Setting $setting, LenderRejectRequest $rejectRequest, LoanRequestLender $loanLender,HoldRequest $holdRequest, LoanEmi $loanEmi)
    {
        $this->loan = $loan;
        $this->setting = $setting;
        $this->rejectRequest = $rejectRequest;
        $this->loanLender = $loanLender;
        $this->holdRequest = $holdRequest;
        $this->loanEmi = $loanEmi;
    }

    /**
     * Request loan term
     * @return array
     */
    public function getLoanTerms()
    {
        return  $this->setting->whereIn('type', [
            'one_month_admin_loan_commission', 'three_month_admin_loan_commission', 'six_month_admin_loan_commission',
            'twelve_month_admin_loan_commission'
        ])->get();
    }
    /**
     * Request loan
     *  @param  object
     * @return boolean
     */
    public function requestLoan($request)
    {
        return $this->loan->create($request);
    }

    /**
     * My loan requests
     *  @param  string, integer
     * @return array
     */
    public function myLoanRequests($type, $userId)
    {

        if ($type == 'pending') {
            return  $this->loan->where('user_id', $userId)->where('loan_status', 'pending')->latest('id')->paginate(10);
        }

        if ($type == 'approved') {
            return  $this->loan->where('user_id', $userId)->whereIn('loan_status', ['approved', 'waiting'])->latest('id')->paginate(10);
        }
        if ($type == 'past') {
            return  $this->loan->where('user_id', $userId)->whereIn('loan_status', ['rejected', 'expired', 'cancelled'])->latest('id')->paginate(10);
        }
        if ($type == 'active') {
            return  $this->loan->where('user_id', $userId)->where('loan_status', 'active')->latest('id')->paginate(10);
        }
        if ($type == 'completed') {
            return  $this->loan->where('user_id', $userId)->where('loan_status', 'completed')->latest('id')->paginate(10);
        }
        return  $this->loan->where('user_id', $userId)->where('loan_status', $type)->latest('id')->paginate(10);
    }

    /**
     * All loan requests
     *  @param  integer
     * @return array
     */
    public function getAllLoanRequests($userId)
    {
        $sql = $this->loan->whereIn('loan_status', ['approved', 'waiting'])->where('user_id', '<>', $userId)->with('user_detail')->select('id', 'user_id', 'loan_interest_rate', 'loan_term','admin_interest_rate', 'total_emi', 'loan_request_date', 'request_expiry_date', 'received_amount', 'loan_request_amount')
            ->whereNotExists(function ($query) use ($userId) {
                $query->select('id')->where('user_id', $userId)->from('lender_reject_requests')->whereRaw('lender_reject_requests.request_id = loan_requests.id');
            })->whereNotExists(function ($query) use ($userId) {
                $query->select('id')->where('user_id', $userId)->from('loan_request_lenders')->whereRaw('loan_request_lenders.request_id = loan_requests.id');
            });
            $sql->wherehas('user_kyc_detail',function($q){
                $q->where(['is_approved'=>1]);
            });
        return  $sql->latest('id')->paginate(10);
    }

    /**
     * Loan request details
     *  @param  int
     * @return array
     */

    public function requestDetail($requestId)
    {
        return  $this->loan->where('id', $requestId)->with('user_detail')->with('lender_list', 'emi_list','inbox_detail')->select('id', 'user_id', 'loan_interest_rate', 'loan_term', 'total_emi', 'loan_request_date','admin_interest_rate', 'loan_cancelled_reason', 'request_expiry_date', 'received_amount', 'payment_frequency', 'loan_request_amount', 'loan_start_date', 'loan_end_date', 'loan_description', 'emi_amount','next_emi_id', 'loan_status')->first();
    }
    /**
     * Cancel loan request
     *  @param  object, int
     * @return boolean
     */
    public function cancelLoanRequest($request, $id)
    {
        return  $this->loan->where('id', $id)->update(array('loan_status' => 'cancelled', 'loan_cancelled_reason' => $request['cancelled_reason']));
    }

    /**
     * Accept loan request
     *  @param  object, string
     * @return boolean
     */

    public function acceptLoanRequest($request)
    {
        return  $this->loanLender->create($request);
    }

    /**
     * Update request status
     *  @param  object, string
     * @return boolean
     */
    public function updateRequestStatus($status, $request)
    {
        if ($status == 'active' || $status == 'waiting') {

            if ($status == 'active') {
                return  $this->loan->where('id', $request['request_id'])->update(array(
                    'loan_status' => $status,
                    'next_emi_date' => $request['next_emi_date'], 'loan_start_date' => $request['loan_start_date'], 'loan_end_date' => $request['loan_end_date'],'next_emi_id' =>   $request['next_emi_id'],
                    'loan_amount_with_interest' => $request['loan_amount_with_interest'], 'emi_amount' => $request['emi_amount'],  'received_amount' => DB::raw('received_amount + ' . $request['paid_amount'])
                ));
            }
            return  $this->loan->where('id', $request['request_id'])->update(array('loan_status' => $status,  'received_amount' => DB::raw('received_amount + ' . $request['paid_amount'])));
        }
        return  $this->loan->where('id', $request['request_id'])->update(array('loan_status' => $status));
    }

    /**
     * Reject loan request
     *  @param  object, string
     * @return boolean
     */
    public function rejectLoanRequest($request)
    {
        return   $this->rejectRequest->create($request);
    }


    /**
     * Check if lender already send money for this request
     *  @param  int, int
     * @return boolean
     */
    public function checkAlreadySendMoney($requestId, $userId)
    {
        return $this->loanLender->where('request_id', $requestId)->where('user_id', $userId)->first();
    }

    /**
     * My investments
     *  @param  int
     * @return array
     */

    public function myInvestments($userId)
    {
        return $this->loanLender->where('user_id', $userId)->with('loan_detail')->latest('id')->paginate(10);
    }
    /**
     * My investments details
     *  @param  int
     * @return array
     */
    public function investmentDetails($userId, $requestId)
    {
        return $this->loanLender->where(['user_id' => $userId, 'request_id' => $requestId])->with('loan_detail')->first();
    }
    /**
     * get user loan requests
     *  @param  integer
     * @return array
     */
    public function userLoanRequest($userId,$requestId)
    {
        return  $this->loan->where(['user_id' => $userId, 'id' => $requestId])->first();
    }
    /**
     * get user loan requests
     *  @param  integer
     * @return array
     */
    public function lenderLoanRequest($userId,$requestId)
    {
        return  $this->loanLender->where(['user_id' => $userId, 'request_id' => $requestId])->first();
    }
    /**
     * get hold requests
     *  @param  integer
     * @return array
     */
    public function getHoldRequest($requestId)
    {
        return  HoldRequest::where(['request_id' => $requestId])->count();
    }
    /**
     * save hold requests
     *  @param  integer
     * @return id
     */
    public function saveHoldRequest($data)
    {
        return  HoldRequest::create($data);
    }
    /**
     * get hold requests
     *  @param  integer
     * @return boolean
     */
    public function deleteHoldRequest($requestId)
    {
        return  HoldRequest::where(['id' => $requestId])->delete();
    }
    /**
     * Save EMI List
     *  @param  object
     * @return id
     */
    public function saveEmiList($data)
    {
        return  LoanEmi::create($data);
    }

    /**
     * Manual Pay Loan EMI
     * @param object, int
     * @return object
     */
    public function payLoanEmi($request) {
        try{
            // \Log::info();
            $loanId = $request['request_id'];
            $emiId = $request['emi_id'];
            $walletBalance = $request['user']['wallet_balance'];
            DB::beginTransaction();
            $emiInfo = LoanEmi::where('id',$emiId)->whereIn('emi_status',['pre_paid','paid'])->first();
            if ($emiInfo) {
                DB::rollback();
                return 'exist';
            }
            $currentDate = date("Y-m-d H:i:s");
            $requestData = $this->loan->where('id', $loanId)->first();
            $lenderData = LoanRequestLender::where('request_id', $requestData['id'])->get();
            $loanAmount = $requestData['received_amount'];
            $interestAmount = $requestData['loan_amount_with_interest']-$loanAmount;
            $adminInterestRate = ($requestData['admin_interest_rate']*100)/$requestData['loan_interest_rate'];

            $adminTotalCommission = getAdminCommission($interestAmount,$adminInterestRate);
            // $adminTotalCommission = getAdminCommission($interestAmount,$requestData['admin_interest_rate']);
            if($requestData['emi_amount'] > $walletBalance){
                DB::rollback();
                return 'insufficient_wallet_balance';
            }
            $adminEmiCommission = $adminTotalCommission/$requestData['total_emi'];

            $adminInfo = getAdminInfo();
            $userInfo = User::where('id', $requestData['user_id'])->first();
            // Emi distribute to lenders
            $loanEmi = $requestData['emi_amount']-$adminEmiCommission;

            $emiUpdateData['emi_paid_date'] =  $currentDate;
            $emiUpdateData['emi_status'] =  'pre_paid';
            $update = LoanEmi::where('id',$emiId)->update($emiUpdateData);

            $emiCount = LoanEmi::where(['request_id'=>$loanId])->whereIn('emi_status',['paid','pre_paid'])->count();
            $emiDetail = LoanEmi::where(['id'=>$emiId])->first();

            if($emiCount >= $requestData['total_emi']){
                $updateData['loan_status'] = 'completed';
            }
            $emi_date = strtotime($emiDetail['emi_date']);

            $emiMonth = date('F', strtotime($emi_date));

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
            $update = $this->loan->where('id',$loanId)->update($updateData);
            // if(!$create){
            //     DB::rollBack();
            //     return false;
            // }
            if(!empty($lenderData)){
                // Add amount in Admin wallet for hold Lender commission
                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$loanId,'emi_id'=>$emiId,'transaction_type'=>'lender_hold_amount','payment_type'=>'credit','amount'=>$loanEmi,'comments'=>'Emi amount credited as hold amount for lender on behalf of Request Id '.$loanId];
                $adminWalletData = addWalletTransaction($adminWalletData);


                // Add amount in Admin wallet on behalf of Loan request
                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'credit','amount'=>$adminEmiCommission,'comments'=>'Emi amount credited on behalf of Request Id '.$loanId];
                $adminWalletData = addWalletTransaction($adminWalletData);

                // Debit amount from user wallet on behalf of Loan request
                $userWalletData = ['user_id'=>$requestData['user_id'],'request_id'=>$loanId,'transaction_type'=>'loan_emi','payment_type'=>'debit','amount'=>$requestData['emi_amount'],'comments'=>'Emi amount debited on behalf of Request Id '.$loanId];

                $userWalletData = addWalletTransaction($userWalletData);

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

                    // Notification for Admin
                    $adminNotificationData['request_id'] = $loanId;
                    $adminNotificationData['message'] = 'Naira '.$emailData['emiAmount'].' added in your wallet by '. $userInfo->name.' on '. $currentDate.'for EMI of '.$emiMonth.'.';
                    $adminNotificationData['to_id'] = $adminInfo['id'];
                    $adminNotificationData['from_id'] = $userInfo->id;
                    $adminNotificationData['created_at'] = $currentDate;
                    $adminNotificationData['type']=config('constants.notification_type.pay_emi');

                    Notification::create($adminNotificationData);
                // ************************Push Notifications*******************************

                DB::commit();
                return $emiId;
            }else{
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            // DB::rollBack();
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
}
