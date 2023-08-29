<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SupportValidation;
use App\Repositories\SettingRepository;
use App\Repositories\LoanRepository;
use DB;

class SettingController extends Controller
{

    public function __construct(SettingRepository $setting, LoanRepository $loan)
    {
        $this->setting = $setting;
        $this->loan = $loan;
    }

    /**
     * Request invest
     *  @param  object
     * @return object
     */
    public function supportRequest(SupportValidation $request)
    {
        try {
            $adminInfo=getAdminInfo();
            $data['user_id'] = $request['user']['id'];
            $data['request_id'] = $request['request_id'];
            $data['title'] = $request['title'];
            $data['description'] = $request['description'];
            $userRequest = $this->loan->userLoanRequest($data['user_id'],$request['request_id']);
            $lenderRequest = $this->loan->lenderLoanRequest($data['user_id'],$request['request_id']);

            if (!$userRequest && !$lenderRequest) {
                return response()->json(['success' => false, 'data' => [], 'message' => __('api.request_id_not_match')], 422);
            }

            $insert = $this->setting->supportRequest($data);

            // $responseData = ['transaction_id'=>$insert->id,'invest_amount'=>$data['invest_amount'],'wallet_balance'=>$wallet_balance];

            // ************************Admin Notifications*******************************
               $userIdsData[]=$adminInfo->id;
               $dataAdmin['request_id']=$data['request_id'];
               $dataAdmin['message']='User ('.$request['user']['name'].') has sent you a support request. For more details go to support section.';
               $dataAdmin['to_id']=$adminInfo->id;
               $dataAdmin['from_id']=$data['user_id'];
               $dataAdmin['type']=config('constants.notification_type.support_mail_for_admin');
               sendPushNotification($dataAdmin, $userIdsData);

            // ************************Admin Notifications end******************************

            return response()->json(['success' => true, 'data' => $data, 'message' => __('api.support_request_added')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
    /**
     * Get CMS detail
     * @param string
     * @return array
     */
    public function getCmsDetail($type)
    {
        $cmsData = url('/cms-web-view/'.$type);

        if (!$cmsData) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No data found!!'], 422);
        }
        return response()->json(['success' => true, 'error' => [], 'data' =>  $cmsData]);
    }

}
