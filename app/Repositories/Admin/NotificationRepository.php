<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\Models\Notification;


class NotificationRepository {

    public function __construct(Notification $notification) {
        $this->notification = $notification;
    }

    /**
     * Get notification data
     * @param object
     * @return type
     */
    public function getNotification() {
        $adminId = getAdminInfo()->id;
        // return $this->notification->get();
        return $this->notification->where(['to_id'=>$adminId,'is_read'=>'0'])->orderBy('id','DESC')->limit('5')->get();
    }
    /**
     * Get notification data
     * @param object
     * @return type
     */
    public function getNotificationCount() {
        $adminId = getAdminInfo()->id;
        return $this->notification->where(['to_id'=>$adminId,'is_read'=>'0'])->count();
    }

    /**
     * get All notifications list
     * @return type
     */
    public function getAllNotifications(){
        $adminId = getAdminInfo()->id;
        $this->notification->where('to_id', $adminId)->update(['is_read'=>'1']);
        $notification = $this->notification->where('to_id', $adminId)->orderBy('id', 'DESC')->paginate(10);
        return $notification;
    }

}
