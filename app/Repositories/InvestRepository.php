<?php

namespace App\Repositories;

use App\Models\InvestRequest;
use App\Models\Setting;
use App\User;
use DB;

class InvestRepository
{

    public function __construct(InvestRequest $invest, Setting $setting)
    {
        $this->invest = $invest;
        $this->setting = $setting;
    }

    /**
     * Request loan term
     * @return array
     */
    public function getInvestTerms()
    {
        return  $this->setting->whereIn('type', [
            'six_month_interest', 'twelve_month_interest'
        ])->get();
    }

    /**
     * get total invest maturity amount
     * @return array
     */
    public function calculateMaturity($request)
    {
        $data['investTerm'] = getTermById($request['invest_term_id']);
        $data['investInterest'] = getInvestInterest($request['invest_term_id']);
        $data['maturityAmount'] = amountWithInterest($request['invest_amount'], $data['investInterest'], $data['investTerm']);

        return $data;
    }
    /**
     * Request loan
     *  @param  object
     * @return boolean
     */
    public function investRequest($request)
    {
        return $this->invest->create($request);
    }

    /**
     * My invest requests
     *  @param  string, integer
     * @return array
     */
    public function myInvestRequests($type, $userId)
    {
        if ($type == 'pending') {
            return  $this->invest->where('user_id', $userId)->where('status', 'pending')->latest('id')->paginate(10);
        }
        if ($type == 'approved') {
            return  $this->invest->where('user_id', $userId)->whereIn('status', ['approved'])->latest('id')->paginate(10);
        }
        if ($type == 'past') {
            return  $this->invest->where('user_id', $userId)->whereIn('status', ['rejected', 'completed', 'cancelled'])->latest('id')->paginate(10);
        }
    }

    /**
     * My all invest requests
     *  @param  integer
     * @return array
     */
    public function myAllInvestRequests($userId)
    {
        return  $this->invest->where('user_id', $userId)->latest('id')->paginate(10);
    }

    /**
     * Loan request details
     *  @param  int
     * @return array
     */

    public function requestDetail($requestId)
    {
        return  $this->loan->where('id', $requestId)->with('user_detail')->with('lender_list', 'Emi_list')->select('id', 'user_id', 'loan_interest_rate', 'loan_term', 'total_emi', 'loan_request_date', 'request_expiry_date', 'received_amount', 'payment_frequency', 'loan_request_amount', 'loan_start_date', 'loan_end_date', 'loan_description', 'emi_amount', 'loan_status')->first();
    }
    /**
     * Cancel loan request
     *  @param  object, int
     * @return boolean
     */
    public function cancelLoanRequest($request, $id)
    {
        return  $this->loan->where('id', $id)->update(array('loan_status' => 'cancelled', 'loan_cancelled_reason' => $request['cancelled_reason']));
    }

    /**
     * Check user invest or not
     *  @param  int
     * @return object
     */
    public function checkUserInvest($userId)
    {
        return  $this->invest->where('user_id', $userId)->first();
    }
}
