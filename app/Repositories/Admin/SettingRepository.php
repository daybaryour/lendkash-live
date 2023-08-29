<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserDetail;
use App\Models\Setting;
use App\Models\Wallet;


class SettingRepository {

    public function __construct(User $user, UserDetail $userDetail, Setting $setting, Wallet $wallet) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->setting = $setting;
        $this->wallet = $wallet;

    }

    /**
     * Get commission data
     * @return object
     */
    public function getCommission() {
        $type = ['one_month_admin_loan_commission','three_month_admin_loan_commission','six_month_admin_loan_commission','twelve_month_admin_loan_commission'];
        $sql = $this->setting->whereIn('type',$type)->get();
        return $sql;
    }
    /**
     * Get invest commission data
     * @return object
     */
    public function getInvestInterest() {
        $type = ['six_month_interest','twelve_month_interest'];
        $sql = $this->setting->whereIn('type',$type)->get();
        return $sql;
    }
    /**
     * Get wallet commission data
     * @return object
     */
    public function getWalletCommission() {
        $sql = $this->setting->where('type','wallet_commission_to_bank_account')->first();
        return $sql;
    }
    /**
     * Get wallet commission data
     * @return object
     */
    public function getLoanCommission() {
        $sql = $this->setting->where('type','commission_for_loan_request')->first();
        return $sql;
    }
    /**
     * Get wallet commission data
     * @return object
     */
    public function getInvestCommission() {
        $sql = $this->setting->where('type','commission_for_invest_request')->first();
        return $sql;
    }

    /**
     * update commission
     * @param object
     * @return object
     */
    public function updateCommission($request) {
        try{
            $this->setting->where('type', 'one_month_admin_loan_commission')->update(['value' => $request['one_month_admin_loan_commission']]);
            $this->setting->where('type', 'three_month_admin_loan_commission')->update(['value' => $request['three_month_admin_loan_commission']]);
            $this->setting->where('type', 'six_month_admin_loan_commission')->update(['value' => $request['six_month_admin_loan_commission']]);
            $this->setting->where('type', 'twelve_month_admin_loan_commission')->update(['value' => $request['twelve_month_admin_loan_commission']]);

            return json_encode(array('success' => true, 'message' => 'Loan commission updated successfully!'));

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * update invest commission
     * @param object
     * @return object
     */
    public function updateInvestCommission($request) {
        try{
            $this->setting->where('type', 'six_month_interest')->update(['value' => $request['six_month_interest']]);
            $this->setting->where('type', 'twelve_month_interest')->update(['value' => $request['twelve_month_interest']]);

            return json_encode(array('success' => true, 'message' => 'Invest commission updated successfully!'));

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * update wallet commission
     * @param object
     * @return object
     */
    public function updateWalletCommission($request) {
        try{
            $this->setting->where('type', 'commission_for_loan_request')->update(['value' => $request['commission_for_loan_request']]);
            $this->setting->where('type', 'wallet_commission_to_bank_account')->update(['value' => $request['wallet_commission_to_bank_account']]);

            return json_encode(array('success' => true, 'message' => 'Admin commission updated successfully!'));

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * Get Loan Commission
     * @param object
     * @return object
     */
    public function loadAdminCommission($request) {
        try{
            $adminId = getAdminInfo()->id;

            $sql = $this->wallet->with('loan_request')->where(['user_id'=>$adminId,'payment_type'=>'credit','transaction_type'=>'loan_emi']);
                    $sql->wherehas('loan_request',function($q) use ($request){
                        $q->whereIn('loan_status',['active','completed']);
                    });
                    if (!empty($request->requestId)) {
                            $sql->where('request_id',$request->requestId);
                    }
                    if (!empty($request->userName)) {
                        $sql->wherehas('loan_request.user_detail',function($q) use ($request){
                            $q->where('users.name','like','%'.$request->userName.'%');
                        });
                    }
                    if (!empty($request->loanAmount)) {
                        $sql->wherehas('loan_request',function($q) use ($request){
                            $q->where('received_amount',$request->loanAmount);
                        });
                    }
                    if (!empty($request->receiveAmount)) {
                        $sql->where('amount',$request->receiveAmount);
                    }
                    if (!empty($request->commissionDate)) {
                        $commissionDate = date('Y-m-d', strtotime($request->commissionDate));
                        $sql->whereDate('created_at', '=', $commissionDate);
                    }
            return  $sql->latest('id')->get();

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    /**
     * Get Wallet to Bank Transfer Commission
     * @param object
     * @return object
     */
    public function loadWalletCommission($request) {
        try{
            $adminId = getAdminInfo()->id;

            $sql = $this->wallet->with('payment_transaction')->where(['user_id'=>$adminId,'payment_type'=>'credit','transaction_type'=>'bank_transfer']);
                    if (!empty($request->requestId)) {
                            $sql->where('request_id',$request->requestId);
                    }
                    if (!empty($request->userName)) {
                        $sql->wherehas('loan_request.user_detail',function($q) use ($request){
                            $q->where('users.name','like','%'.$request->userName.'%');
                        });
                    }
                    if (!empty($request->loanAmount)) {
                        $sql->wherehas('loan_request',function($q) use ($request){
                            $q->where('received_amount',$request->loanAmount);
                        });
                    }
                    if (!empty($request->receiveAmount)) {
                        $sql->where('amount',$request->receiveAmount);
                    }
                    if (!empty($request->commissionDate)) {
                        $commissionDate = date('Y-m-d', strtotime($request->commissionDate));
                        $sql->whereDate('created_at', '=', $commissionDate);
                    }
            return  $sql->latest('id')->get();

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * Get EMI lender holding amount detail
     * @param object
     * @return object
     */
    public function emiLenderHoldAmount($request) {
        try{
            $adminId = getAdminInfo()->id;

            $sql = $this->wallet->with('loan_request')->where(['user_id'=>$adminId,'transaction_type'=>'lender_hold_amount']);
                    if (!empty($request->requestId)) {
                            $sql->where('request_id',$request->requestId);
                    }
            return  $sql->orderBy('created_at','DESC')->get();

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

}

