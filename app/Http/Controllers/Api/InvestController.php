<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RequestInvestValidation;
use App\Repositories\InvestRepository;
use App\Models\Notification;
use DB;

class InvestController extends Controller
{

    public function __construct(InvestRepository $invest)
    {
        $this->invest = $invest;
    }

    /**
     * Invest term
     * @return array
     */
    public function getInvestTerms()
    {

        $invests = $this->invest->getInvestTerms();
        foreach ($invests as $invest) {
            if ($invest['type'] == 'six_month_interest') {
                $invest['name'] = "6 months";
            }
            if ($invest['type'] == 'twelve_month_interest') {
                $invest['name'] = "12 months";
            }
        }
        return response()->json(['success' => true, 'error' => [], 'data' =>  $invests]);
    }


    /**
     * Calculate Maturity
     * @return array
     */
    public function calculateMaturity(Request $request){
        try {
            $investData = $this->invest->calculateMaturity($request);

            return response()->json(['success' => true, 'error' => [], 'data' =>  $investData]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Request invest
     *  @param  object
     * @return object
     */
    public function requestInvest(RequestInvestValidation $request)
    {
        try {
            DB::beginTransaction();
            $adminId = getAdminInfo()->id;
            $userWallet = $request['user']['wallet_balance'];
            $data['user_id'] = $request['user']['id'];
            $data['invests_term'] = getTermById($request['invest_term_id']);
            $data['interest_rate'] = getInvestInterest($request['invest_term_id']);
            $data['invest_amount'] = $request['invest_amount'];
            $data['maturity_amount'] = amountWithInterest($request['invest_amount'],$data['interest_rate'],$data['invests_term']);
            $wallet_balance = $userWallet-$request['invest_amount'];

            if ($userWallet < $data['invest_amount']) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.insufficient_balance_for_this_request')]);
            }

            $insert = $this->invest->investRequest($data);

            if (!$insert) {
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.invest_request_not_added')],500);
            }
            $userWalletData = ['user_id'=>$data['user_id'],'request_id'=>$insert->id,'transaction_type'=>'invest','payment_type'=>'debit','amount'=>$data['invest_amount'],'comments'=>'Your wallet amount debited on behalf of Invest Id '.$insert->id];
            $adminWalletData = ['user_id'=>$adminId,'request_id'=>$insert->id,'transaction_type'=>'invest','payment_type'=>'credit','amount'=>$data['invest_amount'],'comments'=>'Your wallet amount credited on behalf of Invest Id '.$insert->id];

            $updateUserWallet = addWalletTransaction($userWalletData);
            $updateAdminWallet = addWalletTransaction($adminWalletData);
            if (!$updateUserWallet || !$updateAdminWallet){
                DB::rollBack();
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.invest_request_not_added')],500);
            }
            // Notification for Admin
            $adminNotificationData['message'] = 'New investment request arrived. You can approve it from investment request in the investment section.';
            $adminNotificationData['to_id'] = $adminId;
            $adminNotificationData['from_id'] = $data['user_id'];
            $adminNotificationData['created_at'] = date("Y-m-d H:i:s");
            $adminNotificationData['type']=config('constants.notification_type.invest_request');

            Notification::create($adminNotificationData);

            DB::commit();
            $responseData = ['transaction_id'=>$insert->id,'invest_amount'=>$data['invest_amount'],'wallet_balance'=>$wallet_balance];
            return response()->json(['success' => true, 'data' => $responseData, 'message' => __('api.invest_request_added')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * get invest request by status
     * @param int,string
     * @return array
     */
    public function myInvestRequests($type, Request $request){
        try {

            $userId = $request['user']['id'];
            $invests = $this->invest->myInvestRequests($type, $userId);
            foreach ($invests as $invest) {
                if ($invest['status'] == 'approved') {
                    $invest['maturity_percent'] = investMaturityPercent($invest['invest_start_date'],$invest['invest_end_date']);
                }
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $invests]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

}
