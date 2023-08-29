<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\BankDetail;
use App\Models\PaymentTransaction;
use App\Models\Wallet;
use App\Models\UserDetail;
use App\Models\BankMaster;

use DB;

class WalletRepository {

    public function __construct(User $user, BankDetail $bank,PaymentTransaction $payment, UserDetail $userDetail) {
        $this->user = $user;
        $this->bank = $bank;
        $this->payment = $payment;
        $this->userDetail = $userDetail;
    }

    /**
     * User bank list
     * @return object
     */
    public function getBanksDetails() {
        if (request()->ajax()) {
            $adminId = getAdminInfo()->id;
            return $this->bank->where('user_id',$adminId)->get();
        }
    }

    /**
     * Get bank by search list
     * @return object
     */
    public function getAllBanks() {
        return BankMaster::where('status','active')->get();
    }

    /**
     * Load transaction list
     * @param string
     * @return object
     */
    public function loadTransactionList($request) {
        if (request()->ajax()) {
            $sql = Wallet::where('user_id','<>',getAdminInfo()->id)->where('send_money_type','no');

            if (!empty($request->requestId)) {
                $sql->where('request_id',$request->requestId);
            }
            if (!empty($request->transactionDate)) {
                $transactionDate = date('Y-m-d', strtotime($request->transactionDate));
                $sql->whereDate('created_at', '=', $transactionDate);
            }
            if (!empty($request->amount)) {
                $sql->where('amount','<=',$request->amount);
            }
            if (!empty($request->type)) {
                $sql->where('transaction_type',$request->type);
            }
            return $sql->latest('id')->get();
        }
    }

    /**
     * save faqs
     * @param type $request
     * @return object
     */
    public function addBank($request){
        try {
            $adminId = getAdminInfo()->id;
            $post = $request->all();
            $model = new $this->bank();
            $model->user_id = $adminId;
            $bankDetail = BankMaster::where('id',$post['bank_name'])->first();

            $model->bank_name =  $bankDetail['name'];

            $model->bank_code =  $bankDetail['bank_code'];
            // $model->bvn =  $post['bvn'];
            $model->account_holder_name =  $post['account_holder_name'];
            $model->account_number =  $post['account_number'];
            if($model->save()){
                return json_encode(array('success' => true, 'message' => 'Bank account added successfully.'));
            }else{
                return json_encode(array('success' => false, 'message' => 'Please try again'));
            }
        } catch (Exception $ex) {
           return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    /**
     * Delete bank
     *  @param  integer
     * @return boolean
     */
    public function deleteBank($id)
    {
        $res =  $this->bank->where(['id' => $id])->delete();
        if($res){
            return json_encode(array('success' => true, 'message' => 'Bank has been deleted successfully.'));
        }else{
            return json_encode(array('success' => false, 'message' => 'Please try again'));
        }
    }
    /**
     * Create Bank Transfer
     * @param object
     * @return array
     */
    public function bankTransfer($request)
    {
        try {
            DB::beginTransaction();
            $bankDetail = $this->bank->where('id',$request['bankId'])->first();
            $adminInfo = getAdminInfo();

            $userWallet = UserDetail::where('user_id',$adminInfo['id'])->first();
            $amount = $request->amount;

            if ($request['transferAmount']<150) {
                return json_encode(array('success' => false, 'message' =>  __('api.fund_transfer_wrong')));
            }
            if ($request['transferAmount'] > $userWallet->wallet_balance) {
                return json_encode(array('success' => false, 'message' =>  __('api.insufficient_wallet_balance')));
            }

            $data['user_id'] = $adminInfo['id'];
            $data['amount'] = $request['transferAmount'];
            $data['account_number'] = $bankDetail['account_number'];
            $data['account_bank'] = $bankDetail['bank_code'];
            $data['type'] = 'bank_transfer';
            $data['currency'] = 'NGN';

            $insert = $this->payment->create($data);

            if(!$insert){
                return json_encode(array('success' => false, 'message' => 'No payment created!!'));
            }

            $transferData['bank_code'] = $bankDetail['bank_code'];
            $transferData['account_number'] = $bankDetail['account_number'];
            $transferData['beneficiary_name'] = $bankDetail['account_holder_name'];
            $transferData['transferAmount'] = $request['transferAmount'];

            $result = bankTransfer($transferData);
            $jsonData = $result['data'];
            if($result['status']==='error'){
                return json_encode(array('success' => false, 'message' => $result['message']));
            }
            if($jsonData['status']=='FAILED'){
                $status = 'failed';
                $message = $jsonData['complete_message'];
            }elseif($jsonData['status']=='NEW'){
                $status = 'pending';
                $message = 'Your transaction is successful.';
            }
            $paymentId = $insert['id'];
            $updateData['rave_ref'] = ($jsonData['reference'])?$jsonData['reference']:'';
            $updateData['transaction_id'] = $jsonData['id'];
            $updateData['transaction_fee'] = $jsonData['fee'];
            $updateData['bank_name'] = ($jsonData['bank_name'])?$jsonData['bank_name']:'';
            $updateData['payment_status'] = $status;
            $updateData['transaction_message'] = ($jsonData['complete_message'])?$jsonData['complete_message']:'';
            $updateData['logs'] = json_encode($result);

            $save = $this->payment->where('id',$paymentId)->update($updateData);
            // Debit amount from user wallet
            if($jsonData['status']!='FAILED'){
                $adminInfo = getAdminInfo();
                // Add amount in Admin wallet on behalf of bank transfer request

                $adminWalletData = ['user_id'=>$adminInfo['id'],'request_id'=>$paymentId,'transaction_type'=>'bank_transfer','payment_type'=>'debit','amount'=>$request['transferAmount'],'comments'=>'Commission amount credited on behalf of Transaction Id '.$paymentId];
                $adminWalletData = addWalletTransaction($adminWalletData);

            }

            // Debit amount from user wallet
            $responseData['transaction_id'] = $jsonData['id'];
            $responseData['status'] = $status;
            $responseData['message'] = $message;
            DB::commit();
            if($jsonData['status']=='FAILED'){
                return json_encode(array('success' => false, 'message' => $message));
            }elseif($jsonData['status']=='NEW'){
                return json_encode(array('success' => true, 'message' => $message));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

}
