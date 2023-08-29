<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\GroupMember;
use App\Models\Inbox;
use  App\Models\RequestLoan;
use App\Models\Notification;

class ChatRepository
{
    public function __construct(Inbox $inbox, Chat $chat, GroupMember $groupMember, RequestLoan $loan, Notification $notification)
    {
        $this->inbox = $inbox;
        $this->chat = $chat;
        $this->groupMember = $groupMember;
        $this->loan = $loan;
        $this->notification = $notification;
    }


    /**
     * Update message
     *  @param  int, string
     * @return boolean
     */
    public function updateInbox($data)
    {
        return $this->inbox->where('id', $data['inbox_id'])->update(['message' => $data['message'], 'user_id' => $data['from_id']]);
    }

    /**
     * Create thread for chat
     *  @param  array
     * @return boolean
     */
    public function createThread($data)
    {
        return $this->inbox->create($data);
    }


    /**
     * Get request id
     *  @param  int
     * @return object
     */

    public function getRequestId($id)
    {
        return $this->inbox->where('id', $id)->first();
    }


    /**
     * Add group members
     *  @param  array
     * @return boolean
     */
    public function addMembers($data)
    {
        return $this->groupMember->create($data);
    }


    /**
     * Get inbox chat
     *  @param  object
     * @return array
     */

    public function getInboxChat($data)
    {
        $keyword = $data['keyword'];
        $userId = $data['user_id'];

        $sql = $this->inbox->where('id', '<>', null);
        $sql->where(function ($q) use ($userId, $keyword) {
            $q->where('type', 'group');
            $q->whereHas('group_members', function ($q2) use ($userId) {
                $q2->where('user_id', $userId);
            });
            if (!empty($keyword)) { //==============for search=============
                $q->where('request_id', $keyword);
            }
        });
        return $sql->orderBy('updated_at', 'DESC')->paginate(10);
    }


    public function notificationUnreadCount($inboxId, $userId){
        return $this->notification->where(['type'=> 'new_message_receive', 'is_read'=>"0", 'to_id'=> $userId, 'request_id'=>$inboxId ])->count();

    }
    /**
     * Get single chat
     *  @param  object
     * @return array
     */
    public function getSingleChat($data)
    {

        $this->notification->where(['request_id'=> $data['inbox_id'], 'to_id'=>$data['user_id'], 'type'=> 'new_message_receive'])->update(['is_read'=>"1"]);
        // return $this->chat->where('inbox_id', $data['inbox_id'])->with('user_detail', 'inbox_detail')->latest('id')->paginate(10)->reverse();
        return $this->chat->where('inbox_id', $data['inbox_id'])->with('user_detail', 'inbox_detail')->latest('id')->paginate(10);
    }

    /**
     * check for user can chat or not
     *  @param  int
     * @return boolean
     */
    public function checkRequestActive($requestId)
    {
        return $this->loan->where(['id' => $requestId])->whereIn('loan_status', ['approved', 'waiting','active'])->count();
    }

    /**
     * Send message
     *  @param  object
     * @return boolean
     */

    public function sendMessage($data)
    {

        $insert = $this->chat->create($data);
        if (!$insert) {
            return false;
        }

        $update = self::updateInbox($data);
        $checkGroupMember = $this->groupMember->where(['inbox_id' => $data['inbox_id'], 'user_id' => $data['from_id']])->first();
        if (!$checkGroupMember) {
            $memberData['inbox_id'] = $data['inbox_id'];
            $memberData['user_id'] = $data['from_id'];
            return self::addMembers($memberData);
        }
        return true;
    }
}
