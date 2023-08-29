<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePaymentValidation;
use App\Repositories\PaymentRepository;
use DB;

class PaymentController extends Controller
{

    public function __construct(PaymentRepository $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Create payment request
     *  @param  object
     * @return object
     */
    public function createPayment(CreatePaymentValidation $request)
    {
        try {
            $data['user_id'] = $request['user']['id'];
            $data['amount'] = $request['amount'];
            $data['currency'] = $request['currency'];
            $data['type'] = 'add_money';
            $insert = $this->payment->createPayment($data);

            if(!$insert){
                return response()->json(['success' => false, 'data' => [], 'message' => 'No payment created!!'], 422);
            }
            $responseData['payment_id'] = $insert['id'];

            return response()->json(['success' => true, 'data' => $responseData, 'message' => 'Payment created']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Save payment
     *  @param  object
     * @return object
     */
    public function savePayment(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $userWallet = $request['user']['wallet_balance'];
            $paymentId = $request['payment_id'];
            $paymentType = $request['payment_type'];
            $raveResponse  = $request['rave_response'];
            $jsonData =  json_decode($request['json_data']);
            if($raveResponse==='failed'){
                $data['payment_status'] = 'failed';
                $data['transaction_message'] = $jsonData->message;
                $data['logs'] = $request['json_data'];
                $save = $this->payment->savePayment($data,$paymentId);
                return response()->json(['success' => true, 'data' => [], 'message' => $jsonData->message]);
            }
            $updateData =  $jsonData->data;
            $data['transaction_id'] = $updateData->txid;
            $data['transaction_ref'] = $updateData->txref;
            $data['currency'] = $updateData->currency;
            $data['charged_amount'] = $updateData->chargedamount;
            $data['payment_status'] = $updateData->status;
            $data['payment_type'] = $updateData->paymenttype;
            $data['payment_id'] = $updateData->paymentid;
            $data['charge_type'] = $updateData->chargetype;
            $data['order_ref'] = $updateData->orderref;
            $data['transaction_message'] = $jsonData->message;
            $data['rave_ref'] = $updateData->raveref;
            $data['logs'] = $request['json_data'];
            $data['card_number'] = ($request['card_number'])?$request['card_number']:'';
            if($paymentType=='account'){
                $data['account_number'] = $updateData->account->account_number;
                $data['account_bank'] = $updateData->account->account_bank;
            }
            $save = $this->payment->savePayment($data,$paymentId);

            if(!$save){
                return response()->json(['success' => false, 'data' => [], 'message' => 'No payment created!!'], 422);
            }

            if($paymentType=='card'){
                if(!empty($updateData->card) && $updateData->card!=''){
                    $cardData['user_id'] = $userId;
                    $cardData['expiry_month'] = $updateData->card->expirymonth;
                    $cardData['expiry_year'] = $updateData->card->expiryyear;
                    $cardData['card_bin'] = $updateData->card->cardBIN;
                    $cardData['last_four_digits'] = $updateData->card->last4digits;
                    $cardData['brand'] = $updateData->card->brand;
                    $cardData['issuing_country'] = $updateData->card->issuing_country;
                    $cardData['type'] = $updateData->card->type;
                    $cardData['card_tokens'] = json_encode($updateData->card->card_tokens);
                    $cardData['embed_token'] = $updateData->card->card_tokens[0]->embedtoken;
                    $cardData['log'] = json_encode($updateData->card);
                    $cardData['created_at'] = date("Y-m-d H:i:s");
                    $saveCard = $this->payment->saveCard($cardData);
                }
            }

            // Add amount in user wallet
            if($updateData->status=='successful'){
                // $adminInfo = getAdminInfo();
                // Add amount in Admin wallet on behalf of Loan request
                // $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$paymentId,'transaction_type'=>'add_money','payment_type'=>'credit','amount'=>$updateData->amount,'comments'=>'Emi amount credited on behalf of Request Id '.$paymentId];
                // $adminWalletData = addWalletTransaction($adminWalletData);

                $userWalletData = ['user_id'=>$userId,'request_id'=>$paymentId,'transaction_type'=>'add_money','payment_type'=>'credit','amount'=>$updateData->amount,'comments'=>'Amount is successfully added in your wallet.'];

                $userWalletData = addWalletTransaction($userWalletData);
                $userWallet = $userWallet + $updateData->amount;
            }


            $responseData['payment_id'] = $paymentId;
            $responseData['wallet_balance'] = $userWallet;
            // $responseData['transaction_id'] = $save['transaction_id'];
            // $responseData['amount'] = $save['amount'];
            // $responseData['transaction_ref'] = $save['transaction_ref'];
            // $responseData['payment_status'] = $save['payment_status'];
            // $responseData['payment_type'] = $save['payment_type'];
            // $responseData['rave_ref'] = $save['rave_ref'];

            return response()->json(['success' => true, 'data' => $responseData, 'message' => 'Your payment is successful.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Get Saved Cards
     * @param string
     * @return array
     */
    public function getSavedCards(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $lenders = $this->payment->getSavedCards($userId);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $lenders]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Delete Saved Cards
     * @param string
     * @return array
     */
    public function deleteSaveCard($card_id)
    {
        try {
            $card = $this->payment->deleteSaveCard($card_id);
            if($card){
                return response()->json(['success' => true, 'error' => [], 'message' =>  'Your card is deleted successfully.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Check Transfer Commission
     * @param string
     * @return array
     */
    public function checkTransferCommission(Request $request)
    {
        try {
            $userWallet = $request['user']['wallet_balance'];
            $adminCommission = getAdminWalletBankCommission();
            $amount = $request->amount;
            $comm = getAdminCommission($amount,$adminCommission);
            $transferAmount = $amount-$comm;

            if ($transferAmount<=150) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.fund_transfer_wrong')], 422);
            }

            $result = 'The commission on your transferring amount is '.$comm.' and '.$transferAmount.' amount will transfer in your bank account.';
            return response()->json(['success' => true, 'error' => [], 'data' =>  $result]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Create Bank Transfer
     * @param string
     * @return array
     */
    public function createBankTransfer(Request $request)
    {
        try {
            DB::beginTransaction();
            $userWallet = $request['user']['wallet_balance'];
            $adminCommission = getAdminWalletBankCommission();
            $amount = $request->amount;
            $comm = getAdminCommission($amount,$adminCommission);
            $transferAmount = $amount-$comm;

            if ($transferAmount<=150) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.fund_transfer_wrong')], 422);
            }
            if ($userWallet<$amount) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_wallet_balance')], 422);
            }

            $data['user_id'] = $request['user']['id'];
            $data['amount'] = $transferAmount;
            $data['account_number'] = $request['account_number'];
            $data['account_bank'] = $request['bank_code'];
            $data['type'] = 'bank_transfer';
            $data['currency'] = 'NGN';

            $insert = $this->payment->createPayment($data);

            if(!$insert){
                return response()->json(['success' => false, 'data' => [], 'message' => 'No payment created!!'], 422);
            }
            $result = createBankTransfer($request,$transferAmount);
            $jsonData = json_encode($result['data']);
            $jsonData = json_decode($jsonData);
            if($result['status']==='error'){
                return response()->json(['success' => false, 'data' => [], 'message' => $result['message']], 422);
            }
            if($jsonData->status=='FAILED'){
                $status = 'failed';
                $message = $jsonData->complete_message;
            }elseif($jsonData->status=='NEW'){
                $status = 'pending';
                $message = 'Your transaction is successful.';
            }
            $paymentId = $insert['id'];
            $updateData['rave_ref'] = ($jsonData->reference)?$jsonData->reference:'';
            $updateData['transaction_id'] = $jsonData->id;
            $updateData['transaction_fee'] = $jsonData->fee;
            $updateData['bank_name'] = ($jsonData->bank_name)?$jsonData->bank_name:'';
            $updateData['payment_status'] = $status;
            $updateData['transaction_message'] = ($result['message'])?$result['message']:'';
            $updateData['logs'] = json_encode($result);
            $save = $this->payment->savePayment($updateData,$paymentId);
            // Debit amount from user wallet
            if($jsonData->status!='FAILED'){
                $adminInfo = getAdminInfo();
                // Add amount in Admin wallet on behalf of bank transfer request

                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$paymentId,'transaction_type'=>'bank_transfer','payment_type'=>'credit','amount'=>$comm,'comments'=>'Commission amount credited on behalf of Transaction Id '.$paymentId];
                $adminWalletData = addWalletTransaction($adminWalletData);

                $userWalletData = ['user_id'=>$request['user']['id'],'request_id'=>$paymentId,'transaction_type'=>'bank_transfer','payment_type'=>'debit','amount'=>$amount,'comments'=>'Amount is debited from your wallet and credited in your bank account.'];
                $userWalletData = addWalletTransaction($userWalletData);
            }

            // Debit amount from user wallet
            $responseData['transaction_id'] = $jsonData->id;
            $responseData['status'] = $status;
            $responseData['message'] = $message;

            DB::commit();
            return response()->json(['success' => true, 'error' => [], 'data' =>  $responseData]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

}
