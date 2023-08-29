<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\InvestRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class InvestRequestController extends Controller
{

    public function __construct(InvestRepository $invest)
    {
        $this->invest = $invest;
    }

    /**
     * Load customer
     * @param  object
     * @return object
     */
    public function investRequest(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->invest->investRequest($request);
                $action_type_info['type'] = 'investRequest';
                $action_type_info['columnType'] = 'action';
                return DataTables::of($data)->addColumn('action', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('user_name', function ($data){
                    return $data['user_detail']['name'];
                })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('invest.invest-request');
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
    public function updateInvestStatus($id, $status)
    {
        try {
            return $this->invest->updateInvestStatus($id, $status);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * get loan requests.
     * @param  int
     * @return object
     */
    public function getInvestRequests()
    {
        try{
            return view("invest.invest-list");
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
    public function loadInvestAjaxPage($status)
    {
        try{
            if($status=='approved'){
                return view("invest._currentInvest-list");
            }else{
                return view("invest._pastInvest-list");
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
    public function loadInvestRequest(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->invest->loadInvestRequest($request);
                $action_type_info['type'] = 'investRequest';
                $action_type_info['columnType'] = 'action';
                return DataTables::of($data)->addColumn('action', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('user_name', function ($data){
                    return $data['user_detail']['name'];
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

}
