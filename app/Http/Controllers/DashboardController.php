<?php

namespace App\Http\Controllers;
use App\Repositories\Admin\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardRepository $dashboard)
    {
        // $this->middleware('auth');
        $this->dashboard = $dashboard;
    }

    /**
     * @return object
     */
    public function index()
    {
        $data['userCount'] = $this->dashboard->userCount();
        $data['loanRequest'] = $this->dashboard->loanRequestCount();
        $data['investRequest'] = $this->dashboard->investRequestCount();
        $data['registerUser'] = $this->dashboard->registerUser();
        $data['investMonthCount'] = $this->dashboard->investMonthCount();
        $data['loanMonthCount'] = $this->dashboard->loanMonthCount();
        return view('dashboard',$data);
    }
    /**
     * @return object
     */
    public function mailSend()
    {
        $emailData['email'] = 'rajatmagre@gmail.com';
        $emailData['name'] = 'Rajat';
        $emailData['requestId'] = '10';
        $emailData['type'] = 'lenderEmi';
        $emailData['emiAmount'] = '100';
        $emailData['subject'] = 'EMI for Loan';
        $res = sendMails('emails.loan-request', $emailData);
        // return $res;
    }
}
