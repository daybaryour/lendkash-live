<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserDetail;
use App\Models\InvestRequest;


class InvestRepository {

    public function __construct(User $user, UserDetail $userDetail, InvestRequest $investRequest) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->investRequest = $investRequest;

    }
    /**
     * Load user loan request
     * @param int
     * @return object
     */
    public function investRequest($request) {
        if (request()->ajax()) {
            $sql = $this->investRequest->with('user_detail')->where('status','pending');
            if (!empty($request->investRequestId)) {
                $sql->where('id', $request->investRequestId);
            }
            if (!empty($request->investTerm)) {
                $sql->where('invests_term',$request->investTerm);
            }
            if (!empty($request->startDate)) {
                $startDate = date('Y-m-d', strtotime($request->startDate));
                $sql->whereDate('created_at', '=', $startDate);
            }
            if (!empty($request->investAmount)) {
                $sql->where('invest_amount',$request->investAmount);
            }
            return $sql->latest('id')->get();
        }
    }
    /**
     * Delete user
     * @param int
     * @return object
     */
    public function updateInvestStatus($id,$status) {
        try{
            $model = $this->investRequest->where('id', $id)->first();
            $userInfo = $this->user->where('id', $model['user_id'])->first();
            $adminId = getAdminInfo()->id;
            if($model){
                // calculate invest start date and maturity date
                if($status=='approved'){
                    $startDate = date("Y-m-d H:i:s");
                    $endDate1 = date('Y-m-d H:i:s', strtotime($startDate .$model['invests_term']." months"));
                    $endDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($endDate1)));

                    $model->invest_start_date = $startDate;
                    $model->invest_end_date = $endDate;
                }else{
                    // Debit amount from user wallet on behalf of Loan request
                    $adminWalletData = ['user_id'=>$adminId,'request_id'=>$id,'transaction_type'=>'invest','payment_type'=>'debit','amount'=>$model['invest_amount'],'comments'=>'Amount debited on behalf of Request Id '.$id];
                    $adminWalletData = addWalletTransaction($adminWalletData);
                    // Add amount in Admin wallet on behalf of Loan request
                    $userWalletData = ['user_id'=>$userInfo['id'],'request_id'=>$id,'transaction_type'=>'invest','payment_type'=>'credit','amount'=>$model['invest_amount'],'comments'=>'Amount credited on behalf of reject Request Id '.$id];
                    $userWalletData = addWalletTransaction($userWalletData);
                }
                $model->status = $status;


                if($model->save()){

                    // ************************Email Notifications*******************************
                        $emailData['email'] = $userInfo->email;
                        $emailData['name'] = $userInfo->name;
                        $emailData['requestId'] = $id;
                        $emailData['type'] = 'investApprove';
                        $emailData['invest_amount'] = $model['invest_amount'];
                        $emailData['status'] = $status;
                        $emailData['subject'] = 'Invest request status';
                        sendMails('emails.invest-request', $emailData);
                    // ************************Email Notifications*******************************
                    // ************************Push Notifications*******************************
                    if($status=='approved'){
                        $userIds[]=$userInfo->id;
                        $data['request_id']=$id;
                        $data['message']='Your invest Request Id '.$id.' is approved by admin. Your amount Naira '.$model['invest_amount'].' is deducted from your wallet.';
                        // $data['to_id']=$userInfo->id;
                        $data['from_id']=$adminId;
                        $data['type']=config('constants.notification_type.invest_request');
                        sendPushNotification($data, $userIds);
                    }else{
                        $userIds[]=$userInfo->id;
                        $data['request_id']=$id;
                        $data['message']='Your invest Request Id '.$id.' has been rejected by admin. Your amount Naira '.$model['invest_amount'].' is credited in your wallet.';
                        // $data['to_id']=$userInfo->id;
                        $data['from_id']=$adminId;
                        $data['type']=config('constants.notification_type.invest_request');
                        sendPushNotification($data, $userIds);
                    }
                    // ************************Push Notifications*******************************
                    return json_encode(array('success' => true, 'message' => 'Invest request  '.$status.' successfully!'));
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
     * Load user loan request
     * @param int
     * @return object
     */
    public function loadInvestRequest($request) {
        if (request()->ajax()) {
            $sql = $this->investRequest->with('user_detail')->where('status',$request['status']);
            if (!empty($request->investRequestId)) {
                $sql->where('id', $request->investRequestId);
            }
            if (!empty($request->investTerm)) {
                $sql->where('invests_term',$request->investTerm);
            }
            if (!empty($request->startDate)) {
                $startDate = date('Y-m-d', strtotime($request->startDate));
                $sql->whereDate('invest_start_date', '=', $startDate);
            }
            if (!empty($request->endDate)) {
                $endDate = date('Y-m-d', strtotime($request->endDate));
                $sql->whereDate('invest_end_date', '=', $endDate);
            }
            if (!empty($request->investAmount)) {
                $sql->where('invest_amount',$request->investAmount);
            }
            return $sql->latest('id')->get();
        }
    }

}
