<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\LoanRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class LoanRequestController extends Controller
{

    public function __construct(LoanRepository $loan, UserRepository $user)
    {
        $this->loan = $loan;
        $this->user = $user;
    }

    /**
     * Load customer
     * @param  object
     * @return object
     */
    public function approvalLoans(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->loan->approvalLoans($request);
                $action_type_info['type'] = 'loanRequest';
                $action_type_info['columnType'] = 'action';
                $action_type_info['loan_status'] = 'pending';
                return DataTables::of($data)->addColumn('action', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('user_name', function ($data){
                    return $data['user_detail']['name'];
                })
                ->addColumn('loan_description', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "loan_description";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('loan_interest_rate', function ($data){
                    return $data['loan_interest_rate'].'%';
                })
                    ->rawColumns(['action','loan_description'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('loan-requests.approval-loans');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
     /**
     * Update Loan status.
     * @param  int, string
     * @return object
     */
    public function updateLoanStatus($id, $status)
    {
        try {
            return $this->loan->updateLoanStatus($id, $status);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * get loan requests.
     * @param  int
     * @return object
     */
    public function getLoansRequests()
    {
        try{
            return view("loan-requests.request-list");
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
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Pay loan EMI.
     * @param  int
     * @return object
     */
    public function payMissedLoanEmi($id)
    {
        try{
            return $this->loan->payMissedLoanEmi($id);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Check Loan Expiry.
     * @return object
     */
    public function checkLoanRequestExpiry()
    {
        try{
            return $this->loan->checkLoanRequestExpiry();
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Check Invest maturity.
     * @return object
     */
    public function checkInvestMaturity()
    {
        try{
            return $this->loan->checkInvestMaturity();
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load customer
     * @param  object
     * @return object
     */
    public function unPaidEmiList(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->loan->unPaidEmiList($request);
                return DataTables::of($data)->editColumn('action', function ($data){
                    if($data['status']=="paid"){
                        return '<strong >Paid</strong>';
                    }else{
                        return '<span class="paybtn'.$data->emi_id.'"><button class="btn btn-primary ripple-effect" type="button" onclick="payMissedEmi('.$data['emi_id'].')">Pay</button></span>';
                    }
                })
                ->editColumn('status', function ($data){
                    if($data['status']=="paid"){
                        return '<strong >Paid</strong>';
                    }else{
                        return '<strong >UnPaid</strong>';
                    }
                })
                ->rawColumns(['action','status'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('loan-requests.un-paid-emi-list');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
}
