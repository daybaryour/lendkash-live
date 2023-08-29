<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\NotificationRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{

    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

     /**
     * Load notification List.
     * @return object
     */
    public function index()
    {
        try {
            return view("notification.index");
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Load view all notification Section
     * @param  object
     */
    public function loadAllNotificationList(){
        try {
            $notificationList = $this->notification->getAllNotifications();
            $html = View::make("notification._load-all-notification-list", ['notificationList' => $notificationList])->render();
            return Response::json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }
     /**
     * Load notification List.
     * @return object
     */
    public function getNotification()
    {
        try {
            $notifications = $this->notification->getNotification();
            $notificationCount = $this->notification->getNotificationCount();
            $html = View::make("notification._ajaxListing", ['notifications' => $notifications])->render();
            
            return Response::json(['success' => true, 'html' => $html,'notificationCount'=>$notificationCount]);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }


}
