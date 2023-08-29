<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckMobileNumberValidation;
use App\Http\Requests\Api\SendMoneyRequestValidation;
use App\Http\Requests\Api\SendMoneyValidation;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use DB;

class WalletController extends Controller
{

    public function __construct(WalletRepository $wallet, UserRepository $user)
    {
        $this->wallet = $wallet;
        $this->user = $user;
    }

    /**
     * Check number exist or not
     *  @param  object
     * @return boolean
     */

    public function checkUserExistByNumber(CheckMobileNumberValidation $request)
    {
        try {
            $checkNumberExist = $this->user->checkPhoneNumberExist($request);
            if (!$checkNumberExist || $checkNumberExist['status'] == 'inactive') {
                return response()->json(['success' => true, 'data' => [], 'message' => __('api.user_not_exist')], 422);
            }
            $responseData['user_id']=$checkNumberExist['id'];
            $responseData['name']=$checkNumberExist['name'];
            $responseData['mobile_number']=$checkNumberExist['mobile_number'];
            $responseData['user_image']=$checkNumberExist['user_image'];
            return response()->json(['success' => true, 'data' => $responseData]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Send money request
     *  @param  object
     * @return boolean
     */
    public function sendRequest(SendMoneyRequestValidation $request)
    {
        try {
            $checkUserExist = $this->user->checkUserExist($request['user_id']);
            if (!$checkUserExist['user_detail']['kyc_status'] || !$checkUserExist['user_detail']['is_approved']) {
                return response()->json(['success' => true, 'data' => [], 'message' => __('api.user_not_exist')], 422);
            }
            if($request['user']['id']==$checkUserExist['id']){
                return response()->json(['success' => true, 'data' => [], 'message' => __('api.you_can_not_send_money_yourself')], 422);
            }
            $data['to_id'] = $request['user']['id'];
            $data['from_id'] = $checkUserExist['id'];
            $data['amount'] = $request['amount'];

            $sendRequest = $this->wallet->sendRequest($data);
            if (!$sendRequest) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.request_not_send')], 500);
            }

                // ************************Push Notifications*******************************
                 $userIds[]=$data['from_id'];
                 $data['request_id']=$sendRequest->id;
                 $data['message']='You have received a request of Naira '.$data['amount'].' form ('.$request['user']['name'].').';
                 $data['from_id']=$data['to_id'];
                 $data['to_id']=$data['from_id'];
                 $data['name']=$request['user']['name'];
                 $data['amount']=$request['amount'];
                 $data['user_image']=$request['user']['user_image'];
                 $data['type']=config('constants.notification_type.wallet_received_request');
                 sendPushNotification($data, $userIds);
                // ************************Push Notifications*******************************
                $responseData['request_id']=$sendRequest->id;
            return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.request_send_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Recent money transaction
     *  @param  object
     * @return array
     */
    public function recentMoneyTransaction(Request $request)
    {
        try {
            $recentTransaction = $this->wallet->recentMoneyTransaction($request['user']['id']);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $recentTransaction]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Pay request money
     *  @param  object
     * @return array
     */

    public function payRequestMoney(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = $request['user']['id'];
            $requestDetail = $this->wallet->checkRequest($request['request_id']);
            $checkUserStatus = $this->wallet->checkUserStatus($requestDetail['to_id']);

            if ($checkUserStatus['status'] != 'active') {
                return response()->json(['success' => true, 'data' => [], 'message' => $checkUserStatus['name'].' is inactive by the admin.'], 422);
            }
            if ($checkUserStatus['user_detail']['is_approved']==0) {
                return response()->json(['success' => true, 'data' => [], 'message' => $checkUserStatus['name'].' KYC is not approved. Please ask username to approve their profile first by the admin.'], 422);
            }
            if ($userId != $requestDetail['from_id'] && $requestDetail['status'] != 'unpaid') {
                return response()->json(['success' => true, 'data' => [], 'message' => __('api.invalid_wallet_request')], 422);
            }
            if ($request['user']['wallet_balance'] < $requestDetail['amount']) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_balance_for_this_request')], 422);
            }
            $paidRequestStatus = $this->wallet->changeRequestStatus($request['request_id']);
            if (!$paidRequestStatus) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.status_not_changes')], 500);
            }

            $walletDataCredit['user_id'] = $requestDetail['from_id'];
            $walletDataCredit['request_id'] = $requestDetail['id'];
            $walletDataCredit['transaction_type'] = "wallet";
            $walletDataCredit['payment_type'] = "debit";
            $walletDataCredit['amount'] = $requestDetail['amount'];
            $credit = addWalletTransaction($walletDataCredit);


            $walletDataDebit['user_id'] = $requestDetail['to_id'];
            $walletDataDebit['request_id'] = $requestDetail['id'];
            $walletDataDebit['transaction_type'] = "wallet";
            $walletDataDebit['payment_type'] = "credit";
            $walletDataDebit['send_money_type'] = "yes";
            $walletDataDebit['amount'] = $requestDetail['amount'];
            $debit = addWalletTransaction($walletDataDebit);

            if (!$credit || !$debit) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.amount_not_send')], 500);
            }
            $responseData['transaction_id'] = $debit->id;
            $responseData['wallet_balance'] = $request['user']['wallet_balance'];

            // ************************Push Notifications******************************
                $userIds[]=$requestDetail['to_id'];
                $data['request_id']= $requestDetail['id'];
                $data['message']='You have received Naira '.$requestDetail['amount'].' form ('.$request['user']['name'].').';
                $data['to_id']=$requestDetail['to_id'];
                $data['from_id']=$requestDetail['from_id'];
                $data['type']=config('constants.notification_type.sent_money');
                sendPushNotification($data, $userIds);
           // ************************Push Notifications*******************************
            DB::commit();
            return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.request_send_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Pay money
     *  @param  object
     * @return boolean
     */

    public function payMoney(SendMoneyValidation $request){
        DB::beginTransaction();
        try{
            $data['from_id'] = $request['user']['id'];
            $data['to_id'] = $request['to_id'];
            $data['amount'] = $request['amount'];
            $data['status'] = "paid";
            $checkUserExist = $this->user->checkUserExist($data['to_id']);
            $checkUserStatus = $this->wallet->checkUserStatus($data['to_id']);

            if ($checkUserStatus['status'] != 'active') {
                return response()->json(['success' => true, 'data' => [], 'message' => $checkUserStatus['name'].' is inactive by the admin.'], 422);
            }
            if ($checkUserStatus['user_detail']['is_approved']==0) {
                return response()->json(['success' => true, 'data' => [], 'message' => $checkUserStatus['name'].' KYC is not approved. Please ask username to approve their profile first by the admin.'], 422);
            }
            if (!$checkUserExist) {
                return response()->json(['success' => true, 'data' => [], 'message' => __('api.user_not_exist')], 422);
            }
            if ($request['user']['wallet_balance'] < $data['amount']) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_balance_for_this_request')], 422);
            }

            $sendRequest = $this->wallet->sendRequest($data);
            if (!$sendRequest) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.request_not_send')], 500);
            }

            $walletDataCredit['user_id'] = $request['to_id'];
            $walletDataCredit['request_id'] = $sendRequest->id;
            $walletDataCredit['transaction_type'] = "wallet";
            $walletDataCredit['payment_type'] = "credit";
            $walletDataCredit['send_money_type'] = "yes";
            $walletDataCredit['amount'] = $data['amount'];
            $credit = addWalletTransaction($walletDataCredit);


            $walletDataDebit['user_id'] = $data['from_id'];
            $walletDataDebit['request_id'] = $sendRequest->id;
            $walletDataDebit['transaction_type'] = "wallet";
            $walletDataDebit['payment_type'] = "debit";
            $walletDataDebit['amount'] = $data['amount'];
            $debit = addWalletTransaction($walletDataDebit);

            if (!$credit || !$debit) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.amount_not_send')], 500);
            }
            $responseData['transaction_id'] = $debit->id;
            $responseData['wallet_balance'] = $request['user']['wallet_balance'];

                // ************************Push Notifications******************************
                $userIds[]=$data['to_id'];
                $data['request_id']= $sendRequest->id;
                $data['message']='You have received Naira '.$data['amount'].' form ('.$request['user']['name'].').';
                $data['to_id']=$data['to_id'];
                $data['from_id']=$data['from_id'];
                $data['type']=config('constants.notification_type.sent_money');
                sendPushNotification($data, $userIds);
               // ************************Push Notifications*******************************


            DB::commit();
           return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.money_send_successfully')]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
    }


    }
     /**
     * Get wallet transaction by type
     *  @param  object
     * @return array
     */

    public function getWalletTransactions(Request $request, $type){
        try {
            $userId = $request['user']['id'];
            $getTransactions=$this->wallet->getWalletTransactions($type,  $userId);
            foreach ($getTransactions as $getTransaction) {
                if($type=='received'){
                    $getTransaction['message'] = "Received from ".$getTransaction['money_request_detail']['from_user_detail']['name'];
                }
                if($type=='sent'){
                    $getTransaction['message'] = "Sent to ".$getTransaction['money_request_detail']['to_user_detail']['name'];
                }
                if($type=='add_money'){
                    $getTransaction['bank_detail'] = $this->wallet->getWalletBankDetail($getTransaction['request_id']);
                }
                if($type=='bank_transfer'){
                    $getTransaction['bank_detail'] = $this->wallet->getWalletBankDetail($getTransaction['request_id']);
                }

            }
            return response()->json(['success' => true, 'data' => $getTransactions, 'wallet_amount' => $request['user']['wallet_balance']]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
