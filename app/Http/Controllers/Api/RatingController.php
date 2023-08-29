<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RatingValidation;
use App\Repositories\RatingRepository;
use App\Repositories\LoanRepository;
use DB;

class RatingController extends Controller
{

    public function __construct(RatingRepository $rating, LoanRepository $loan)
    {
        $this->rating = $rating;
        $this->loan = $loan;
    }

    /**
     * My request loan
     *  @param  string
     * @return array
     */
    public function ratingLoanRequests($type, Request $request)
    {
        try {
            $userId = $request['user']['id'];
            if($type=='borrower'){
                $loans = $this->rating->borrowerLoanRequests($userId);
            }else{
                $loans = $this->rating->lenderLoanRequests($userId);
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $loans]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * My request loan
     *  @param  integer
     * @return array
     */
    public function getRequestLenders($requestId, Request $request)
    {
        try {
            $lenders = $this->rating->getRequestLenders($requestId, $request['user']['id']);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $lenders]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * View rating detail
     *  @param  integer
     * @return array
     */
    public function getRatingDetail($userId, $requestId, Request $request)
    {
        try {
            $from_id = $request['user']['id'];
            $rating = $this->rating->getRatingDetail($userId, $requestId,$from_id);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $rating]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * submit review
     *  @param  object
     * @return object
     */
    public function submitReview(RatingValidation $request)
    {
        try {

            $data['from_id'] = $request['user']['id'];
            $data['to_id'] = $request['to_id'];
            $data['request_id'] = $request['request_id'];
            $data['rating'] = $request['rating'];
            $data['reviews'] = $request['review'];

            // $userRequest = $this->loan->userLoanRequest($data['from_id'],$request['request_id']);

            // if (!$userRequest) {
            //     return response()->json(['success' => false, 'data' => [], 'message' => __('api.request_id_not_match')], 422);
            // }

            $insert = $this->rating->submitReview($data);

            // $responseData = ['transaction_id'=>$insert->id,'invest_amount'=>$data['invest_amount'],'wallet_balance'=>$wallet_balance];
            return response()->json(['success' => true, 'data' => $data, 'message' => __('api.review_submit')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

}
