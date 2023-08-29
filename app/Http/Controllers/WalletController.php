<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Admin\WalletRepository;
use App\Http\Requests\AddBankValidation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
class WalletController extends Controller
{

    public function __construct(WalletRepository $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Load Admin Wallet Page
     * @return object
     */
    public function index()
    {
        try {
            $data['banks'] = $this->wallet->getAllBanks();
            return view('wallet.index',$data);
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Load Admin Wallet Page
     * @return object
     */
    public function loadBankList()
    {
        try {
            $data = $this->wallet->getBanksDetails();
            $html = View::make("wallet._ajaxBankListing", ['data' => $data])->render();
            return Response::json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update Invest Commission.
     * @param  int, string
     * @return object
     */
    public function addBank(Request $request)
    {
        try {
            return $this->wallet->addBank($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Update Invest Commission.
     * @param  int, string
     * @return object
     */
    public function deleteBank($bankId)
    {
        try {
            return $this->wallet->deleteBank($bankId);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Update Invest Commission.
     * @param  int, string
     * @return object
     */
    public function bankTransfer(Request $request)
    {
        try {
            return $this->wallet->bankTransfer($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }


     /**
     * Load Transaction
     * @param  object
     * @return object
     */
    public function getTransaction(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->wallet->loadTransactionList($request);
                $action_type_info['type'] = 'transaction';
                $action_type_info['columnType'] = 'type';
                return DataTables::of($data)->addColumn('type', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('toId', function ($data){
                    return getToUserName($data);
                })
                ->editColumn('fromId', function ($data){
                    return getFromUserName($data);
                })
                ->editColumn('created_at', function ($data){
                    return dateFormat($data['created_at']);
                })
                ->rawColumns(['type','toId','fromId'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('transaction.index');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
}
