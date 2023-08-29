<?php

namespace App\Repositories;

use App\Models\RequestLoan;
use App\Models\MoneyRequest;
use App\Models\Wallet;
use App\Models\PaymentTransaction;
use App\User;
use App\Repositories\InvestRepository;
use DB;

class WalletRepository
{
    public function __construct(MoneyRequest $money, Wallet $wallet, InvestRepository $invest, RequestLoan $loan,PaymentTransaction $payment)
    {
        $this->money = $money;
        $this->wallet = $wallet;
        $this->invest = $invest;
        $this->loan = $loan;
        $this->payment = $payment;
    }


    /**
     * Send money request
     *  @param  object
     * @return boolean
     */
    public function sendRequest($request)
    {
        return  $this->money->create($request);
    }

    /**
     * Check money request
     *  @param  object
     * @return boolean
     */
    public function checkRequest($id)
    {
        return  $this->money->where('id', $id)->first();
    }
    /**
     * Check money request
     *  @param  object
     * @return boolean
     */
    public function checkUserStatus($id)
    {
        $user = User::with('user_detail')->where('id', $id)->first();
        return $user;
    }

    /**
     * Update request status
     * @param  object
     * @return boolean
     */

    public function changeRequestStatus($id)
    {
        return  $this->money->where('id', $id)->update(['status' => 'paid']);
    }

    /**
     * Recent money transaction
     *  @param  object
     * @return array
     */

    public function recentMoneyTransaction($userId)
    {
        $sql = User::where('status', 'active')->select(array('id', 'name', 'email', 'mobile_number'));;
        $sql->whereHas('from_user', function ($q) use ($userId) {
            return $q->where('from_id', '<>',  $userId);
        });
        $sql->orWhereHas('to_user', function ($q) use ($userId) {
            return $q->where('to_id', '<>', $userId);
        });

        return $sql->latest('id')->paginate(10);
    }

    /**
     * Get wallet transaction by type
     *  @param  int, int
     * @return array
     */
    public function getWalletTransactions($type, $userId)
    {
        if ($type == 'received') { // Amount received by receive money on send request
            return    $this->wallet->where(["user_id" => $userId, "payment_type" => 'credit', 'transaction_type' => 'wallet'])->with('money_request_detail.from_user_detail')->latest('id')->paginate(10);
        }
        if($type=='sent'){ // Amount sent on receive money request
            return    $this->wallet->where(["user_id" => $userId, "payment_type" => 'debit', 'transaction_type' => 'wallet'])->with('money_request_detail.to_user_detail')->latest('id')->paginate(10);
        }
        if($type=='bank_transfer'){ // Amount sent on receive money request
            return    $this->wallet->where(["user_id" => $userId, 'transaction_type' => 'bank_transfer'])->latest('id')->paginate(10);
        }
        if($type=='add_money'){ // Amount sent on receive money request
            return    $this->wallet->where(["user_id" => $userId, 'transaction_type' => 'add_money'])->latest('id')->paginate(10);
        }
        if($type=="amount_received_via_emi"){ // Amount receive via EMI
            return    $this->wallet->where(["user_id" => $userId, "payment_type" => 'credit', 'transaction_type' => 'loan_emi'])->with('loan_request')->latest('id')->paginate(10);
        }
        if($type=="invest"){ //All transactions on Invest
            return $this->invest->myAllInvestRequests($userId);
        }
        if($type=="loan_requested"){ // As a borrower  credit and debit amount
            return $this->wallet->where(["user_id" => $userId,'transaction_type' => 'loan','payment_type'=>'credit'])->latest('id')->paginate(10);
         }
    }

    public function getWalletBankDetail($requestId)
    {
        $paymentData = PaymentTransaction::where('id', $requestId)->first();
        if(!empty($paymentData)){
            if($paymentData['type']=='bank_transfer'){
                $data['account_number'] = 'XXXXXXXX'.substr($paymentData['account_number'],-6);
                $data['payment_type'] = 'Bank';
            }else{
                $data['payment_type'] = $paymentData['payment_type'];
                if($paymentData['payment_type']=='account'){
                    $data['account_number'] = 'XXXXXXXX'.substr($paymentData['account_number'],-6);
                }else{
                    $data['account_number'] = 'XXXXXXXXXXXX'.$paymentData['card_number'];
                }
            }
            return $data;
        }
    }

}
