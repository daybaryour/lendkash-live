<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\RatingRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class RatingController extends Controller
{

    public function __construct(RatingRepository $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Load Loan request Rating list
     * @param  object
     * @return object
     */
    public function loadRatings(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->rating->loadRatings($request);
                return DataTables::of($data)->editColumn('action', function ($data){
                    return '<a class="theme-color" href="rating-detail/'.base64_encode($data['request_id']).'">View</a>';
                })
                ->editColumn('user_name', function ($data){
                    return getUserNameByRequestId($data->request_id);
                })
                ->rawColumns(['action','user_name'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('rating.index');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
     /**
     * Update KYC status.
     * @param  int, string
     * @return object
     */
    public function changeRatingFlag($id)
    {
        try {
            return $this->rating->changeRatingFlag($id);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }

    /**
     * get user detail.
     * @param  int
     * @return object
     */
    public function ratingDetail($requestId)
    {
        try{
            $requestId = base64_decode($requestId);
            $data['borrowerRatings'] = $this->rating->getBorrowerRatings($requestId);
            $data['lenderRatings'] = $this->rating->getLenderRatings($requestId);
            return view("rating.rating-details", $data);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

}
