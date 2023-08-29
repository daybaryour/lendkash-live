<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\SettingRepository;
use App\Http\Requests\CommissionValidation;
use App\Http\Requests\InvestCommissionValidation;
use App\Http\Requests\WalletCommissionValidation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Get Commission data
     * @return object
     */
    public function index()
    {
        try {
            $data['commissionData'] =  $this->setting->getCommission();
            $data['investInterest'] =  $this->setting->getInvestInterest();
            $data['getLoanCommission'] =  $this->setting->getLoanCommission();
            $data['walletCommission'] =  $this->setting->getWalletCommission();
            return view('setting',$data);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
     /**
     * Update Commission.
     * @param  int, string
     * @return object
     */
    public function updateCommission(CommissionValidation $request)
    {
        try {
            return $this->setting->updateCommission($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
     /**
     * Update Invest Commission.
     * @param  int, string
     * @return object
     */
    public function updateInvestCommission(InvestCommissionValidation $request)
    {
        try {
            return $this->setting->updateInvestCommission($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
     /**
     * Update Invest Commission.
     * @param  int, string
     * @return object
     */
    public function updateWalletCommission(WalletCommissionValidation $request)
    {
        try {
            return $this->setting->updateWalletCommission($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Load Loan commission list
     * @param  object
     * @return object
     */
    public function loadAdminCommission(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->setting->loadAdminCommission($request);
                return DataTables::of($data)
                ->editColumn('user_name', function ($data){
                    return $data['loan_request']['user_name'];
                })
                ->editColumn('loan_amount', function ($data){
                    return $data['loan_request']['received_amount'];
                })
                ->rawColumns(['user_name'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('commission.index');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load Wallet commission list
     * @param  object
     * @return object
     */
    public function loadWalletCommission(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->setting->loadWalletCommission($request);
                return DataTables::of($data)
                ->editColumn('user_name', function ($data){
                    return getUserNameByUserId($data['payment_transaction']['user_id']);
                })
                ->editColumn('transaction_amount', function ($data){
                    return $data['payment_transaction']['amount'];
                })
                ->rawColumns(['user_name'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('commission.walletCommission');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load Wallet commission list
     * @param  object
     * @return object
     */
    public function emiLenderHoldAmount(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->setting->emiLenderHoldAmount($request);
                return DataTables::of($data)
                ->editColumn('payment_type', function ($data){
                    if($data['payment_type']=="debit"){
                        return "Release";
                    }else{
                        return "Hold";
                    }
                })
                ->rawColumns(['payment_type'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('wallet.emiHoldingAmount');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
}
