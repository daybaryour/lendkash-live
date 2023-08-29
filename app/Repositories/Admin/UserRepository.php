<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserDetail;
use App\Models\RequestLoan;
use App\Models\LoanRequestLender;


class UserRepository {

    public function __construct(User $user, UserDetail $userDetail, RequestLoan $requestLoan) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->requestLoan = $requestLoan;

    }

    /**
     * Load customer
     * @param object
     * @return type
     */
    public function loadUsers($request) {
        if (request()->ajax()) {
            $sql = $this->user->where('status','<>','deleted')->role('user')->with('user_detail');
            if (!empty($request->filter_name)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('name', 'LIKE', '%' . $request->filter_name . '%');
                });
            }
            if (!empty($request->filter_email)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('email', 'LIKE', '%' . $request->filter_email . '%');
                });
            }
            if (!empty($request->filter_mobile)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('mobile_number', 'LIKE', '%' . $request->filter_mobile . '%');
                });
            }
            return $sql->latest('users.id')->get();
        }
    }

    /**
     * Update user KYC status
     * @param int, string
     * @return object
     */
    public function updateKycStatus($id, $status) {
        if($status==0){
            $status_val = 'disapproved';
        } else {
            $status_val = 'approved';
        }
        $this->userDetail->where('user_id', $id)->update(['is_approved' => $status]);

           // ************************Push Notifications******************************
           $adminInfo=getAdminInfo();
           $userIds[]=$id;
           $data['request_id']= null;
           $data['message']='Your KYC account has been '.$status_val.' by admin.';
           $data['to_id']=$id;
           $data['from_id']=$adminInfo->id;
           $data['type']="kyc_account_verified";
           sendPushNotification($data, $userIds);
          // ************************Push Notifications*******************************

        return json_encode(['success' => 'yes', 'message' => 'User KYC '.$status_val.' successfully.', 'status' => $status]);
    }
    /**
     * Update user status
     * @param int, string
     * @return object
     */
    public function updateUserStatus($id, $status) {
        if($status==0){
            $status_val = 'inactive';
        } else {
            $status_val = 'active';
        }
        $this->user->where('id', $id)->update(['status' => $status_val]);
        // ************************Push Notifications******************************
            $adminInfo=getAdminInfo();
            $userIds[]=$id;
            $data['request_id']= null;
            $data['message']='User status has been '.$status_val.' by admin.';
            $data['to_id']=$id;
            $data['from_id']=$adminInfo->id;
            $data['type']="user_status";
            sendPushNotification($data, $userIds);
       // ************************Push Notifications*******************************
        return json_encode(['success' => 'yes', 'message' => 'User status '.$status_val.' successfully.', 'status' => $status]);
    }
    /*
     * update profile
     * @return array
     */
    public function updateProfile($request){
        try{
            $user_id = auth()->guard('admin')->user()->id;
            if ($request['profile_image']) {
                $imageUpload = uploadImage($request['profile_image'], "user_image");
                $this->userDetail->where('user_id', $user_id)->update(['user_image' => $imageUpload]);
                return $this->user->where('id', $user_id)->update(['name' => $request['name']]);
            } else {
                return $this->user->where('id', $user_id)->update(['name' => $request['name']]);
            }

        } catch (\Exception $e) {
            $response = ['success' => false, 'error' => ['message' => $e->getMessage()]];
            return $response;
        }
    }
    /**
     * Get user info
     * @return object
     */
    public function getUserInfo() {
        return auth()->guard('admin')->user();
    }
    /**
     * Change password for admin.
     * @param object
     * @return boolean
     */
    public function changePassword($request) {
        $user = self::getUserInfo();
        if (!\Hash::check($request['current_password'], $user->password)) {
            return "notmatch";
        } else {
            return $update = $this->user->where('id', $user['id'])
                    ->update(array('password' => bcrypt($request['new_password'])));
        }
    }
    /**
     * Get user detail
     * @param int
     * @return object
     */
    public function getUserDetail($id) {
        return $this->user->with('user_detail')->where('id', $id)->first();
    }
    /**
     * Load user loan request
     * @param int
     * @return object
     */
    public function loadLoanRequest($request) {
        if (request()->ajax()) {
            if (!empty($request['user_id'])) {
                $sql = $this->requestLoan->where(['user_id'=>$request['user_id'],'loan_status'=>$request['loan_status']]);
            }else{
                $sql = $this->requestLoan->where(['loan_status'=>$request['loan_status']]);
            }
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
                $sql->where('received_amount','=',$request->loanAmount);
            }
            if (!empty($request->loanRequestDate)) {
                $loanRequestDate = date('Y-m-d', strtotime($request->loanRequestDate));
                $sql->whereDate('created_at', '=', $loanRequestDate);
            }
            if (!empty($request->loanCompleteDate)) {
                $loanCompleteDate = date('Y-m-d', strtotime($request->loanCompleteDate));
                $sql->whereDate('loan_end_date', '=', $loanCompleteDate);
            }
            if (!empty($request->loanExpiredDate)) {
                $loanExpiredDate = date('Y-m-d', strtotime($request->loanExpiredDate));
                $sql->whereDate('request_expiry_date', '=', $loanExpiredDate);
            }
            if (!empty($request->previous_emi_date)) {
                $previous_emi_date = date('Y-m-d', strtotime($request->previous_emi_date));
                $sql->whereDate('last_emi_date', '=', $previous_emi_date);
            }
            if (!empty($request->next_emi_date)) {
                $next_emi_date = date('Y-m-d', strtotime($request->next_emi_date));
                $sql->whereDate('next_emi_date', '=', $next_emi_date);
            }
            if (!empty($request->emi_start_date)) {
                $emi_start_date = date('Y-m-d', strtotime($request->emi_start_date));
                $sql->whereDate('loan_start_date', '=', $emi_start_date);
            }
            if (!empty($request->emi_end_date)) {
                $emi_end_date = date('Y-m-d', strtotime($request->emi_end_date));
                $sql->whereDate('loan_end_date', '=', $emi_end_date);
            }
            return $sql->latest('id')->get();
        }
    }
    /**
     * Delete user
     * @param int
     * @return object
     */
    public function deleteUser($id) {
        $userDeviceData = $this->userDevice->where('user_id', $id)->first();
        $removedToken = invalidToken($userDeviceData['user_id']);
        return $delete = $this->user->where('id', $id)->update(['status' => 'deleted']);
    }

}
