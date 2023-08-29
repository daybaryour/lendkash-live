<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

     /**
     * Get notifications
     * @param  object
     * @return array
     */

    public function getNotifications(Request $request)
    {
        try {
            $userId = $request['user']['id'];
            $notifications=$this->notification->getNotifications($userId);
            foreach ($notifications as $value) {
                if($value->type=='wallet_received_request'){
                    $value['received_request_status'] =  receivedRequestStatus($value->request_id);
                }else{
                    $value['received_request_status'] = 0;
                }
                $data = json_decode($value->notification_data);
                $value['notification_data'] = $data;
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $notifications]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' =>  $e->getMessage()]]);
        }
    }
}
