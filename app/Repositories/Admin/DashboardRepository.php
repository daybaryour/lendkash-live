<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\RequestLoan;
use App\Models\InvestRequest;
use App\Models\LoanRequestLender;
use DB;


class DashboardRepository {

    public function __construct(User $user, RequestLoan $loan, InvestRequest $invest, LoanRequestLender $lender) {
        $this->user = $user;
        $this->loan = $loan;
        $this->invest = $invest;
        $this->lender = $lender;

    }

    /**
     * User Count
     * @return int
     */
    public function userCount() {
        return $this->user->where('role','user')->count();
    }
    /**
     * Loan Request Count
     * @return array
     */
    public function loanRequestCount() {
        $totalLoanCount =  $this->loan->count();
        $completeLoan =  $this->loan->where('loan_status','completed')->count();
        $activeLoan =  $this->loan->where('loan_status','active')->count();
        $rejectedLoan =  $this->loan->where('loan_status','rejected')->count();
        $lenderAmount =  $this->loan->whereIn('loan_status',['active','completed','waiting'])->sum('received_amount');
        $requestAmount =  $this->loan->whereIn('loan_status',['active','completed','waiting','pending','approved'])->sum('loan_request_amount');
        $requestA =  $this->loan->whereIn('loan_status',['waiting','approved'])->sum('loan_request_amount');
        $receiveA =  $this->loan->whereIn('loan_status',['waiting','approved'])->sum('received_amount');
        $collectAmount = $requestA-$receiveA;
        $result = ['totalLoanCount'=>$totalLoanCount,'completeLoan'=>$completeLoan,'activeLoan'=>$activeLoan,'rejectedLoan'=>$rejectedLoan, 'lenderAmount'=>$lenderAmount,'requestAmount'=>$requestAmount,'collectAmount'=>$collectAmount];
        return $result;
    }
    /**
     * Invest Request Count
     * @return array
     */
    public function investRequestCount() {
        $startDate = date('Y-m-d', strtotime('first day of last month'));
        $endDate = date('Y-m-d', strtotime('last day of last month'));
        $totalInvestCount =  $this->invest->count();
        $completeInvest =  $this->invest->where('status','completed')->count();
        $activeInvest =  $this->invest->where('status','approved')->count();
        $rejectedInvest =  $this->invest->where('status','rejected')->count();
        $investAmount =  $this->invest->whereIn('status',['approved','completed'])->sum('invest_amount');
        $investMaturedAmount =  $this->invest->where('status','completed')->whereDate('invest_end_date', '>=', $startDate)->whereDate('invest_end_date', '<=', $endDate)->sum('maturity_amount');
        $result = ['totalInvestCount'=>$totalInvestCount,'completeInvest'=>$completeInvest,'activeInvest'=>$activeInvest,'rejectedInvest'=>$rejectedInvest, 'investAmount'=>$investAmount,'investMaturedAmount'=>$investMaturedAmount];
        return $result;
    }
    /**
     * User count monthly
     * @return array
     */
    public function registerUser() {

        $currentYear = date("Y");
        $nextYear = date('Y', strtotime($currentYear.' 1 year'));
        $arr = [];
        for ($i=1; $i <= 12; $i++) {
            $sql = $this->user->whereMonth('created_at', '=', $i);
            $sql->whereYear('created_at', '>=', $currentYear);
            $sql->whereYear('created_at', '<', $nextYear);
            $arr[] = $sql->count();
        }
        return $arr;
    }
    /**
     * Invest Count Monthly
     * @return array
     */
    public function investMonthCount() {
        $currentYear = date("Y");
        $nextYear = date('Y', strtotime($currentYear.' 1 year'));
        $arr = [];
        for ($i=1; $i <= 12; $i++) {
            $sql = $this->invest->whereMonth('created_at', '=', $i);
            $sql->whereYear('created_at', '>=', $currentYear);
            $sql->whereYear('created_at', '<', $nextYear);
            $arr[] = $sql->count();
        }
        return $arr;
    }
    /**
     * Loan Count Monthly
     * @return array
     */
    public function loanMonthCount() {
        $currentYear = date("Y");
        $nextYear = date('Y', strtotime($currentYear.' 1 year'));
        $arr = [];
        for ($i=1; $i <= 12; $i++) {
            $sql = $this->loan->whereMonth('created_at', '=', $i);
            $sql->whereYear('created_at', '>=', $currentYear);
            $sql->whereYear('created_at', '<', $nextYear);
            $arr[] = $sql->count();
        }
        return $arr;
    }

}
