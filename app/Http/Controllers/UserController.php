<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LoanRequestLender;
use App\Http\Requests\UpdateProfileValidation;
use App\Http\Requests\ChangePasswordValidation;

class UserController extends Controller
{

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Load customer
     * @param  object
     * @return object
     */
    public function loadUsers(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->user->loadUsers($request);
                $action_type_info['type'] = 'customer';
                $action_type_info['columnType'] = 'action';
                return DataTables::of($data)->editColumn('action', function ($data) use ($action_type_info) {
                    return '<a class="theme-color" href="user-detail/'.base64_encode($data['id']).'">View</a>';
                })->addColumn('is_approved', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "kycStatus";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })->addColumn('status', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "status";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                    ->rawColumns(['action', 'status','is_approved'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('user.index');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
     /**
     * Update User status.
     * @param  int, string
     * @return object
     */
    public function updateUserStatus($id, $status)
    {
        try {
            return $this->user->updateUserStatus($id, $status);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
     /**
     * Update KYC status.
     * @param  int, string
     * @return object
     */
    public function updateKycStatus($id, $status)
    {
        try {
            return $this->user->updateKycStatus($id, $status);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Change password for admin.
     * @param  object
     */
    public function changePassword(ChangePasswordValidation $request)
    {
        try {
            $response = $this->user->changePassword($request);
            if ($response == "notmatch") {
                // \Session::flash('error_msg', __('common.old_password_not_match'));
                // return back();
                return json_encode(array('success' => 'false', 'message' => __('common.old_password_not_match')));
            }
            if (!$response) {
                return json_encode(array('success' => 'false', 'message' => __('common.password_not_changed')));
            }
            return json_encode(array('success' => 'true', 'message' => __('common.password_changed')));
        } catch (\Exception $e) {

            return json_encode(array('success' => 'false', 'message' => $e->getMessage()));
        }
    }
     /**
     * Update Profile.
     * @param  int, string
     * @return object
     */
    public function updateProfile(Request $request)
    {
        try {
            $update = $this->user->updateProfile($request);
            if (!$update) {
                return json_encode(array('success' => false, 'message' => 'Profile not update.'));
            }
            return json_encode(array('success' => true, 'message' => 'Profile updated successfully.'));

        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));

        }
    }
    /**
     * Delete user.
     * @param  int
     * @return object
     */
    public function deleteUser($id)
    {
        try {
            $delete = $this->user->deleteUser($id);
            if ($delete) {
                return json_encode(array('success' => 'true', 'message' => __('admin.user_deleted')));
            } else {
                return json_encode(array('success' => 'false', 'message' => __('admin.user_not_deleted')));
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

    /**
     * get user detail.
     * @param  int
     * @return object
     */
    public function userDetail($userId)
    {
        try{
            $userId = base64_decode($userId);
            $data['user'] = $this->user->getUserDetail($userId);
            return view("user.user-details",$data);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * get user detail.
     * @param  int
     * @return object
     */
    public function loadLoanAjaxLenders($requestId)
    {
        try{
            $data['lenders'] = LoanRequestLender::where(['request_id'=>$requestId])->get();
            return view("user._ajax-lender-list",$data);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load ajax  View.
     * @param  string
     * @return html
     */
    public function loadLoanAjaxPage($status)
    {
        try{
            switch ($status) {
                case "pending":
                    return view("user._underapproval-list");
                    break;
                case "active":
                    return view("user._activeloans-list");
                    break;
                case "waiting":
                    return view("user._loanwaiting-list");
                    break;
                case "cancelled":
                    return view("user._loancancelled-list");
                    break;
                case "rejected":
                    return view("user._loanreject-list");
                    break;
                case "completed":
                    return view("user._loancompleted-list");
                    break;
                case "expired":
                    return view("user._expiredLoans-list");
                    break;
                default:
                    return view("user._underapproval-list");
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Pending Restaurant View.
     * @param  int
     */
    public function loadLoanRequest(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->user->loadLoanRequest($request);
                $action_type_info['type'] = 'loanRequest';
                $action_type_info['columnType'] = 'action';
                $action_type_info['loan_status'] = $request['loan_status'];
                return DataTables::of($data)->addColumn('action', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })

                ->editColumn('paid_emis', function ($data){
                    return getPaidEmi($data['id']);
                })
                ->editColumn('emi_left', function ($data){
                    $emi_left = $data['total_emi']- getPaidEmi($data['id']);
                    return $emi_left;
                })
                ->editColumn('emi_remaining_amount', function ($data){
                    $emi_remaining_amount = ($data['total_emi'] - getPaidEmi($data['id']))*$data['emi_amount'];
                    return $emi_remaining_amount;
                })
                ->editColumn('loan_interest_rate', function ($data){
                    return $data['loan_interest_rate'].'%';
                })
                ->editColumn('loan_term', function ($data){
                    return $data['loan_term'].' Months';
                })
                ->addColumn('loan_description', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "loan_description";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->addColumn('received_amount_percent', function ($data){
                    if($data['received_amount']>0){
                        $received_amount = ($data['received_amount'] * 100)/$data['loan_request_amount'];
                        return number_format($received_amount,2);
                    }else{
                        return 0;
                    }
                })
                ->rawColumns(['action','loan_description','id'])
                ->addIndexColumn()
                ->make(true);
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

}
