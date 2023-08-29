<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Admin\ReportRepository;
use App\Exports\UsersReportExport;
use App\Exports\LoanReportExport;
use App\Exports\InvestReportExport;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
    }

    /**
     * User report
     * @param  object
     * @return object
     */
    public function userReport(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->report->userReport($request);
                return DataTables::of($data)
                ->editColumn('bvn', function ($data){
                    return $data['user_detail']['bvn'];
                })
                ->editColumn('bank_name', function ($data){
                    return $data['user_detail']['bank_name'];
                })
                ->editColumn('employer_detail', function ($data){
                    return $data['user_detail']['employer_detail'];
                })
                ->editColumn('address', function ($data){
                    return $data['user_detail']['address'];
                })
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('report.user-report');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Loan report
     * @param  object
     * @return object
     */
    public function loanReport(Request $request)
    {
        try {
            if (request()->ajax()) {

                $data = $this->report->loanReport($request);
                $action_type_info['type'] = 'loanReport';
                return DataTables::of($data)->editColumn('loan_interest_rate', function ($data){
                    return $data['loan_interest_rate'].'%';
                })
                ->addColumn('loan_description', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "loan_description";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->addColumn('loan_status', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "status";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->rawColumns(['loan_status','loan_description'])
                ->addIndexColumn()
                ->make(true);
            }

            return view('report.loan-report');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Invest report
     * @param  object
     * @return object
     */
    public function investReport(Request $request)
    {
        try {
            if (request()->ajax()) {

                $data = $this->report->investReport($request);
                $action_type_info['type'] = 'investReport';
                return DataTables::of($data)->editColumn('loan_interest_rate', function ($data){
                    return $data['loan_interest_rate'].'%';
                })
                ->editColumn('name', function ($data){
                    return $data['user_detail']['name'];
                })
                ->editColumn('email', function ($data){
                    return $data['user_detail']['email'];
                })
                ->editColumn('mobile_number', function ($data){
                    return $data['user_detail']['mobile_number'];
                })
                ->editColumn('interest_rate', function ($data){
                    return $data['interest_rate'].'%';
                })
                // ->editColumn('invest_start_date', function ($data){
                //     return getDefaultFormat($data['invest_start_date']);
                // })
                ->addColumn('status', function ($data) use ($action_type_info) {
                    $action_type_info['columnType'] = "status";
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->rawColumns(['status'])
                ->addIndexColumn()
                ->make(true);
            }

            return view('report.invest-report');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

    /**
     * Export User Report
     *
     */
    public function exportUserReport(Request $request)
    {
        try {
            $userData = $this->report->userReport($request);
            return Excel::download(new UsersReportExport($userData, $request), 'userReport.xls');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Export Loan Report
     *
     */
    public function exportLoanReport(Request $request)
    {
        try {
            $userData = $this->report->loanReport($request);
            return Excel::download(new LoanReportExport($userData, $request), 'loanReport.xls');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Export Invest Report
     *
     */
    public function exportInvestReport(Request $request)
    {
        try {
            $userData = $this->report->investReport($request);
            return Excel::download(new InvestReportExport($userData, $request), 'investReport.xls');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }


}
