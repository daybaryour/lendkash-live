<?php

namespace App\Repositories;

use App\Models\Rating;
use App\Models\LoanRequestLender;
use App\Models\RequestLoan;
use DB;

class RatingRepository
{

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Support Request
     *  @param  int
     * @return object
     */
    public function lenderLoanRequests($userId)
    {
        $lenders = LoanRequestLender::select(['loan_request_lenders.*', DB::Raw('(select count(*) from `ratings` where `loan_request_lenders`.`request_id` = `ratings`.`request_id` and `loan_request_lenders`.`user_id` = `ratings`.`from_id`) as rating_status')])
                        ->with('loan_detail')
                        ->where(['user_id'=>$userId])
                        ->wherehas('loan_detail',function($q){
                            $q->where('loan_status','=','completed');
                        })
                        ->latest('id')->paginate(10);
        return $lenders;
    }
    /**
     * Support Request
     *  @param  int
     * @return object
     */
    public function borrowerLoanRequests($userId)
    {
        $lenders = RequestLoan::where(['user_id'=>$userId,'loan_status'=>'completed'])->latest('id')->paginate(10);
        return $lenders;
    }
    /**
     * Support Request
     *  @param  int
     * @return object
     */
    public function getRatingDetail($userId, $requestId,$from_id)
    {
        $rating = $this->rating->with('user_detail')->where(['from_id'=>$from_id,'to_id'=>$userId,'request_id'=> $requestId])->first();
        return $rating;
    }
    /**
     * Support Request
     *  @param  object
     * @return boolean
     */
    public function getRequestLenders($requestId)
    {
        $lenders = LoanRequestLender::select(['loan_request_lenders.*', DB::Raw('(select count(*) from `ratings` where `loan_request_lenders`.`request_id` = `ratings`.`request_id` and `loan_request_lenders`.`user_id` = `ratings`.`to_id`) as rating_status')])
                                    ->where('loan_request_lenders.request_id',$requestId)
                                    ->latest('id')->paginate(10);
        return $lenders;
    }

    /**
     * Submit Rating & Review
     *  @param  object
     * @return boolean
     */
    public function submitReview($request)
    {
        return $this->rating->create($request);
    }

}
