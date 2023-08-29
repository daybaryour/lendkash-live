<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function getNotifications($userId)
    {
        $this->notification->where('to_id', $userId)->where('type','<>', 'new_message_receive')->update(['is_read'=>"1"]);
        return  $this->notification->where('to_id', $userId)->where('type','<>', 'new_message_receive')->latest('id')->paginate(10);
    }
}
