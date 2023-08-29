<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\RequestLoan;
use App\Models\InvestRequest;


class ReportRepository {

    public function __construct(User $user, RequestLoan $loan, InvestRequest $invest) {
        $this->user = $user;
        $this->loan = $loan;
        $this->invest = $invest;

    }

    /**
     * User Report
     * @param object
     * @return object
     */
    public function userReport($request) {
        // if (request()->ajax()) {
        try {
            $sql = $this->user->withCount(['userLoanCount','investLoanCount'])->with('user_detail')->where('role','user');
            if (!empty($request->name)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }
            if (!empty($request->email)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('email', 'LIKE', '%' . $request->email . '%');
                });
            }
            if (!empty($request->mobile)) {
                $sql->where(function ($q) use ($request) {
                    return $q->where('mobile_number', 'LIKE', '%' . $request->mobile . '%');
                });
            }
            if (!empty($request->bvn)) {
                $sql->wherehas('user_detail',function($q) use ($request){
                    $q->where('bvn','like','%'.$request->bvn.'%');
                });
            }
            if (!empty($request->location)) {
                $sql->wherehas('user_detail',function($q) use ($request){
                    $q->where('address','like','%'.$request->location.'%');
                });
            }
            return $sql->latest('id')->get();
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load report
     * @param string
     * @return object
     */
    public function loanReport($request) {
        // if (request()->ajax()) {
        try {
            $sql = $this->loan->where('id','<>',0);
            if (!empty($request->requestId)) {
                $sql->where('id',$request->requestId);
            }
            if (!empty($request->amount)) {
                $sql->where('loan_request_amount',$request->amount);
            }
            if (!empty($request->term)) {
                $sql->where('loan_term',$request->term);
            }
            if (!empty($request->interest)) {
                $sql->where('loan_interest_rate',$request->interest);
            }
            if (!empty($request->LoanEMI)) {
                $sql->where('emi_amount',$request->LoanEMI);
            }
            if (!empty($request->paymentFrequency)) {
                $sql->where('payment_frequency',$request->paymentFrequency);
            }
            return $sql->latest('id')->get();
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
        // }
    }
    /**
     * Invest(FD) report
     * @param string
     * @return object
     */
    public function investReport($request) {
        try {
            $sql = $this->invest->with('user_detail')->where('id','<>',0);
            if (!empty($request->name)) {
                $sql->wherehas('user_detail',function($q) use ($request){
                    $q->where('name','like','%'.$request->name.'%');
                });
            }
            if (!empty($request->email)) {
                $sql->wherehas('user_detail',function($q) use ($request){
                    $q->where('email','like','%'.$request->email.'%');
                });
            }
            if (!empty($request->mobile)) {
                $sql->wherehas('user_detail',function($q) use ($request){
                    $q->where('mobile_number','like','%'.$request->mobile.'%');
                });
            }
            if (!empty($request->amount)) {
                $sql->where('invest_amount','=',$request->amount);
            }
            if (!empty($request->status)) {
                $sql->where('status',$request->status);
            }
            if (!empty($request->startDate)) {
                $startDate = date('Y-m-d', strtotime($request->startDate));
                $sql->whereDate('invest_start_date', '=', $startDate);
            }
            if (!empty($request->endDate)) {
                $endDate = date('Y-m-d', strtotime($request->endDate));
                $sql->whereDate('invest_end_date', '=', $endDate);
            }

            if (!empty($request->paymentFrequency)) {
                $sql->where('payment_frequency',$request->paymentFrequency);
            }
            return $sql->latest('id')->get();
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

}
