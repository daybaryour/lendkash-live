<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserDetail;
use App\Models\Rating;
use App\Models\RequestLoan;


class RatingRepository {

    public function __construct(User $user, UserDetail $userDetail, Rating $rating, RequestLoan $requestLoan) {
        $this->user = $user;
        $this->userDetail = $userDetail;
        $this->rating = $rating;
        $this->requestLoan = $requestLoan;

    }

    /**
     * Load customer
     * @param object
     * @return type
     */
    public function loadRatings($request) {
        if (request()->ajax()) {
            $sql = $this->rating->with('loanRequest');
            if (!empty($request->userName)) {
                $sql->wherehas('loanRequest.user_detail',function($q) use ($request){
                    $q->where('name','like','%'.$request->userName.'%');
                });
            }
            if (!empty($request->loanRequestId)) {
                $sql->where('request_id',$request->loanRequestId);
            }
            return $sql->groupBy('ratings.request_id')->get();
        }
    }

    /**
     * Update user status
     * @param int, string
     * @return object
     */
    public function changeRatingFlag($id) {
        $this->rating->where('id', $id)->update(['flag' => 1]);
        return json_encode(['success' => true, 'message' => 'Marked as flag successfully.']);
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
     * Get user detail
     * @param int
     * @return object
     */
    public function getBorrowerRatings($requestId) {
        $requestLoan =  $this->requestLoan->where('id', $requestId)->first();
        return $this->rating->where(['to_id' => $requestLoan['user_id'],'request_id'=>$requestId])->get();
    }
    /**
     * Get user detail
     * @param int
     * @return object
     */
    public function getLenderRatings($requestId) {
        $requestLoan =  $this->requestLoan->where('id', $requestId)->first();
        return $this->rating->where(['from_id' => $requestLoan['user_id'],'request_id'=>$requestId])->get();
    }

}
