<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RequestLoanValidation;
use App\Http\Requests\Api\AcceptLoanValidation;
use App\Repositories\ChatRepository;
use App\Repositories\LoanRepository;
use DB;

class LoanController extends Controller
{

    public function __construct(LoanRepository $loan, ChatRepository $chat)
    {
        $this->loan = $loan;
        $this->chat = $chat;
    }

    /**
     * Loan term
     * @return array
     */
    public function getLoanTerms()
    {
        $loans = $this->loan->getLoanTerms();
        foreach ($loans as $loan) {
            if ($loan['type'] == 'one_month_admin_loan_commission') {
                $loan['name'] = "1 month";
            }
            if ($loan['type'] == 'three_month_admin_loan_commission') {
                $loan['name'] = "3 month";
            }
            if ($loan['type'] == 'six_month_admin_loan_commission') {
                $loan['name'] = "6 month";
            }
            if ($loan['type'] == 'twelve_month_admin_loan_commission') {
                $loan['name'] = "1 year";
            }
        }
        return response()->json(['success' => true, 'error' => [], 'data' =>  $loans]);
    }


    /**
     * Calculate EMI
     * @return array
     */
    public function calculateEMI(Request $request)
    {
        $adminInterestRate = getAdminLoanCommission();
        $request['loan_term'] = getTermById($request['loan_term_id']);
        // $request['loan_interest_rate'] = getInvestInterest($request['loan_term_id']);
        $loan_interest_rate = getInvestInterest($request['loan_term_id']);
        $data['loan_interest_rate'] = $loan_interest_rate+$adminInterestRate['value'];
        $data['total_emi'] = getTotalEmiByTerm($request['loan_term'], $request['payment_frequency']);
        $totalAmount = amountWithInterest($request['total_amount'], $data['loan_interest_rate'], $request['loan_term']);
        $totalEmi=$totalAmount/$data['total_emi'];
        $data['monthly_emi'] = round($totalEmi, 2);
        // $data['loan_interest_rate'] = $request['loan_interest_rate'];

        return response()->json(['success' => true, 'error' => [], 'data' =>  $data]);
    }
    /**
     * Request loan
     *  @param  object
     * @return boolean
     */
    public function requestLoan(RequestLoanValidation $request)
    {
        try {
            DB::beginTransaction();
            $adminInfo=getAdminInfo();
            $date = date("Y-m-d H:i:s");
            $data['user_id'] = $request['user']['id'];
            $data['loan_term'] = getTermById($request['loan_term_id']);
            $data['loan_request_amount'] = $request['loan_request_amount'];
            $data['loan_description'] = $request['loan_description'];
            $data['payment_frequency'] = $request['payment_frequency'];
            $data['total_emi'] = getTotalEmiByTerm($data['loan_term'], $request['payment_frequency']);
            $adminInterestRate = getAdminLoanCommission();
            if (!$adminInterestRate) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.invalid_interest_rate')], 422);
            }
            $data['admin_interest_rate'] = $adminInterestRate['value'];
            $loan_interest_rate = getInvestInterest($request['loan_term_id']);
            $data['loan_interest_rate'] = $loan_interest_rate+$adminInterestRate['value'];
            // $data['loan_interest_rate'] = $loan_interest_rate;
            $data['loan_description'] = $request['loan_description'];
            $data['loan_request_date'] = $date;
            // response from okra
            $data['okra_log'] = $request['okra_log'];
            // $okraData = json_decode($request['okra_log']);
            // $data['okra_record_id'] = ($okraData['record_id'])?$okraData['record_id'] : '';
            // $data['okra_bank_id'] = ($okraData['bank_id'])?$okraData['bank_id']:'';
            // $data['okra_customer_id'] = ($okraData['customer_id'])?$okraData['customer_id']:'';
            $insert = $this->loan->requestLoan($data);
            if (!$insert) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.loan_request_not_added')], 500);
            }
                // ************************Admin Notifications*******************************
                $userIdsData[]=$adminInfo->id;
                $dataAdmin['request_id']=$insert->id;
                $dataAdmin['message']=config('constants.notification_messages.approve_loan_request');
                $dataAdmin['to_id']=$adminInfo->id;
                $dataAdmin['from_id']=$data['user_id'];
                $dataAdmin['type']=config('constants.notification_type.approve_loan_request');
                sendPushNotification($dataAdmin, $userIdsData);

                // ************************Admin Notifications end******************************

                // ************************Create chat thread******************************
                $chatData['request_id']=$insert->id;
                $chatData['user_id']=$data['user_id'];
                $chatData['type']='group';
                $chat=$this->chat->createThread($chatData);

                $memberData['user_id']=$data['user_id'];
                $memberData['inbox_id']=$chat->id;
                $member=$this->chat->addMembers($memberData);


                // ************************Create chat thread End******************************
                if(!$chat){
                    DB::rollBack();
                    return response()->json(['success' => true, 'data' => [], 'message' => __('api.loan_chat_not_added')]);
                }
                DB::commit();
            return response()->json(['success' => true, 'data' => [], 'message' => __('api.loan_request_added')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * My request loan
     *  @param  string
     * @return array
     */
    public function myLoanRequests($type, Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $loans = $this->loan->myLoanRequests($type, $userId);
            foreach ($loans as $loan) {
                if ($loan['loan_status'] == 'approved') {
                    $loan['paid_emi'] = getPaidEmi($loan['id']);
                }
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $loans]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Get all loan requests for home page
     * @return array
     */
    public function getAllLoanRequests(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $currentDate = date("Y-m-d H:i:s");
            $loanRequests = $this->loan->getAllLoanRequests($userId);
            foreach ($loanRequests as $loanRequest) {
                $loanRequest['request_remaining_days'] = remainingDaysFromTwoDate($currentDate, $loanRequest['request_expiry_date']);
                $loanRequest['received_amount_percent'] = receivedAmountPercent($loanRequest['loan_request_amount'], $loanRequest['received_amount']);
                $loanRequest['user_detail']['name'] = $loanRequest['user_detail']['name'];
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $loanRequests, 'wallet_amount' => $request['user']['wallet_balance']]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Loan request details
     *  @param  int
     * @return array
     */

    public function requestDetails(Request $request, $id)
    {
        try {
            $checkAlreadySent = $this->loan->checkAlreadySendMoney($id, $request['user']['id']);
            $loanRequestsDetails = $this->loan->requestDetail($id);
            if ($checkAlreadySent) {
                $loanRequestsDetails['already_send_money'] = 1;
            } else {
                $loanRequestsDetails['already_send_money'] = 0;
            }
            $loanRequestsDetails['received_amount_percent'] = receivedAmountPercent($loanRequestsDetails['loan_request_amount'], $loanRequestsDetails['received_amount']);

            return response()->json(['success' => true, 'error' => [], 'data' =>  $loanRequestsDetails]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Cancel loan request
     *  @param  object
     * @return boolean
     */

    public function cancelLoanRequest(Request $request)
    {
        try {
            $loanRequestsDetails = $this->loan->requestDetail(Request()->id);
            if ($loanRequestsDetails['loan_status'] != "pending") {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.no_pending_request_found')], 422);
            }
            $cancelled = $this->loan->cancelLoanRequest($request, Request()->id);
            if (!$cancelled) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.request_not_cancel')], 500);
            }
            return response()->json(['success' => true, 'data' => [], 'message' => __('api.loan_request_cancelled')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Accept loan request
     * @param  object
     * @return boolean
     */
    public function acceptLoanRequest(AcceptLoanValidation $request)
    {
        try {
            $date = date("Y-m-d H:i:s");
            DB::beginTransaction();
            $data['user_id'] = $request['user']['id'];
            $data['request_id'] = $request['request_id'];
            $data['paid_amount'] = $request['amount'];

            $holdRequest = $this->loan->getHoldRequest($request['request_id']);
            if(!empty($holdRequest)){
                return response()->json(['success' => false, 'data' => [], 'message' => 'Try after some time.'], 422);
            }else{
                $holdId = $this->loan->saveHoldRequest(['request_id'=>$request['request_id']]);
            }

            $requestDetail = $this->loan->requestDetail($request['request_id']);

            if ($requestDetail['loan_status'] == 'pending') {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.no_approved_request_found')], 422);
            }
            if ($requestDetail['loan_status'] != 'approved' && $requestDetail['loan_status'] != 'waiting') {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.no_running_request_found')], 422);
            }

            $checkAlreadySent = $this->loan->checkAlreadySendMoney($requestDetail['id'], $data['user_id']);
            if ($checkAlreadySent) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.you_already_sent_money')], 422);
            }

            $remainingAmount = $requestDetail['loan_request_amount'] - $requestDetail['received_amount'];

            if ($data['paid_amount'] > $remainingAmount) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.account_more_than_remaining_amount')], 422);
            }
            if ($request['user']['wallet_balance'] < $data['paid_amount']) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_balance_for_this_request')], 422);
            }
            $acceptRequest = $this->loan->acceptLoanRequest($data);
            if (!$acceptRequest) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.loan_request_not_accepted')], 500);
            }
            /**===============================Requirement fulfilled===================================== */
            if ($remainingAmount == $request['amount']) {  //wallet
                if ($requestDetail['payment_frequency'] == "monthly") {
                    $requestDetail['payment_frequency'] = "months";
                } else {
                    $requestDetail['payment_frequency'] = "week";
                }
                $data['next_emi_date'] = addDaysInDate("1", $requestDetail['payment_frequency']);
                $data['loan_start_date'] = $date;
                $loan_end_date = addDaysInDate($requestDetail['loan_term'], "months");
                $data['loan_end_date'] = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($loan_end_date)));
                $data['loan_amount_with_interest'] = amountWithInterest($requestDetail['loan_request_amount'], $requestDetail['loan_interest_rate'], $requestDetail['loan_term']);
                $data['emi_amount'] = $data['loan_amount_with_interest'] / $requestDetail['total_emi'];

                // Save  EMI list
                for ($i=1; $i <= $requestDetail['total_emi']; $i++) {
                    $emiData['amount'] = $data['emi_amount'];
                    $emiData['request_id'] = $data['request_id'];
                    $emiData['emi_date'] = addDaysInDate($i, $requestDetail['payment_frequency']);
                    $update = $this->loan->saveEmiList($emiData);
                }

                $nextEmiId = getNextEmi($data['request_id']);
                $data['next_emi_id'] = $nextEmiId->id;

                $update = $this->loan->updateRequestStatus('active', $data);

                /**============================Credit amount in wallet============================== */
                $walletDataCredit['user_id'] = $requestDetail['user_id'];
                $walletDataCredit['request_id'] = $data['request_id'];
                $walletDataCredit['transaction_type'] = "loan";
                $walletDataCredit['payment_type'] = "credit";
                $walletDataCredit['amount'] = $requestDetail['loan_request_amount'];
                $credit = addWalletTransaction($walletDataCredit);

                if (!$credit) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'data' => [], 'message' => __('api.amount_not_credit_into_wallet')], 500);
                }
                // ************************Push Notifications*******************************
                    $userIds[]=$requestDetail['user_id'];
                    $data['request_id']=$data['request_id'];
                    $data['message']='On your loan request ('.$data['request_id'].'), lenders had provided the loan for '.$requestDetail['loan_request_amount'].' amount.';
                    $data['to_id']=$requestDetail['user_id'];
                    $data['from_id']=$data['user_id'];
                    $data['type']=config('constants.notification_type.lender_provided_loan');
                    sendPushNotification($data, $userIds);
                // ************************Push Notifications*******************************

            } else {
                      // ************************Push Notifications*******************************
                      $userIds[]=$requestDetail['user_id'];
                      $data['request_id']=$data['request_id'];
                      $data['message']='On your loan request ('.$data['request_id'].'), lenders had started investing';
                      $data['to_id']=$requestDetail['user_id'];
                      $data['from_id']=$data['user_id'];
                      $data['type']=config('constants.notification_type.lender_started_investing');
                      sendPushNotification($data, $userIds);
                     // ************************Push Notifications*******************************



                $data['next_emi_date'] = null;
                $update = $this->loan->updateRequestStatus('waiting', $data);
            }

            if (!$update) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.loan_request_not_accepted')], 500);
            }
            /**============================Debit amount in wallet============================== */
            $walletDataDebit['user_id'] = $data['user_id'];
            $walletDataDebit['request_id'] = $data['request_id'];
            $walletDataDebit['transaction_type'] = "loan";
            $walletDataDebit['payment_type'] = "debit";
            $walletDataDebit['amount'] = $data['paid_amount'];
            $debit = addWalletTransaction($walletDataDebit);

            if (!$debit) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.loan_request_not_accepted')], 500);
            }

            $responseData['transaction_id']=$debit->id;
            $responseData['wallet_balance'] = $request['user']['wallet_balance'];

            $this->loan->deleteHoldRequest($holdId->id);
            DB::commit();
            return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.loan_request_accepted')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Reject loan request
     * @param  object
     * @return boolean
     */
    public function rejectLoanRequest(Request $request, $id)
    {
        try {
            $data['user_id'] = $request['user']['id'];
            $data['request_id'] = $id;
            $rejectRequest = $this->loan->rejectLoanRequest($data);
            if (!$rejectRequest) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.loan_request_not_rejected')], 500);
            }
            return response()->json(['success' => true, 'data' => [], 'message' => __('api.loan_request_rejected')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * My investments history
     * @param  object
     * @return array
     */
    public function myInvestments(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $myInvestments = $this->loan->myInvestments($userId);
            foreach ($myInvestments as $myInvestment) {
                $myInvestment['emi_amount_received'] = emiAmountReceived($myInvestment['request_id'], $userId);
                $myInvestment['emi_amount_left'] = $myInvestment['paid_amount'] - $myInvestment['emi_amount_received'];
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $myInvestments]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Investments detail
     * @param  object, int
     * @return object
     */

    public function investmentDetails(Request $request, $id)
    {
        try {
            $userId = $request['user']['id'];
            $investmentDetails = $this->loan->investmentDetails($userId, $id);
            $investmentDetails['emi_amount_received'] = emiAmountReceived($investmentDetails['request_id'], $userId);
            $investmentDetails['emi_amount_left'] = $investmentDetails['paid_amount'] - $investmentDetails['emi_amount_received'];
            $investmentDetails['emi_list_paid'] = emiAmountReceivedHistory($investmentDetails['request_id'], $userId);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $investmentDetails]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Auto Payment Loan EMI
     * @param object, int
     * @return object
     */
    public function payLoanEmi(Request $request) {
        try {
            $payLoanEmi = $this->loan->payLoanEmi($request);

            if (!$payLoanEmi) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.emi_not_paid')], 500);
            }
            if ($payLoanEmi=='exist') {
                return response()->json(['success' => false, 'data' => [], 'message' => 'EMI already paid.'], 422);
            }
            if ($payLoanEmi=='insufficient_wallet_balance') {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_wallet_balance')], 422);
            }
            return response()->json(['success' => true, 'data' => [], 'message' => __('api.emi_paid')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
