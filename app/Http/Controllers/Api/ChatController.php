<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use App\Repositories\ChatRepository;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class ChatController extends Controller
{
    public function __construct(ChatRepository $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get inboxes chats
     * @param  object
     * @return array
     */

    public function getInboxChats(Request $request)
    {
        try {
            $data['user_id'] = $request['user']['id'];
            $data['keyword'] = $request['keyword'];
            $inboxes = $this->chat->getInboxChat($data);

            foreach($inboxes as $inbox){
                $inbox['notification_unread_count']=$this->chat->NotificationUnreadCount($inbox['id'], $data['user_id']);
                $requestId = $this->chat->getRequestId($inbox['id']);
                // $records = collect($chats)->sortBy('id')->values()->all();
                // foreach ($chats as $chat) {
                $inbox['can_chat'] = $this->chat->checkRequestActive($requestId['request_id']);
            }
            return response()->json(['success' => true, 'error' => [], 'data' =>  $inboxes]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Get inbox single chat
     * @param  int
     * @return array
     */
    public function getSingleChat($inboxId, Request $request)
    {
        try {
            $data['user_id'] = $request['user']['id'];
            $data['inbox_id'] = $inboxId;
            $chats = $this->chat->getSingleChat($data);
            // $records = collect($chats)->sortBy('id')->values()->all();
            foreach ($chats as $chat) {
                $chat['can_chat'] = $this->chat->checkRequestActive($chat['inbox_detail']['request_id']);
            }

            // $page = $request->get('page', 1);
            // $perPage = 2;

            // $myCollectionObj=collect($chats)->sortBy('id')->values()->all(); // for show data in descending with reverse order
            // $newData= $this->customPaginate($myCollectionObj,  $perPage, $page, $inboxId);

            return response()->json(['success' => true, 'error' => [], 'data' =>  $chats]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }




     /**
     * For custom paginate
     * @var array
     */
    public function customPaginate($items, $perPage = 2, $page = null, $id)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,  ['path' => url("api/get-chat/".$id)]);
    }



    /**
     * Insert notification when user is offline.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveNotification(Request $request)
    {
        // ************************Push Notifications*******************************
        $userIds[] = $request['to_id'];
        $data['inbox_id'] = $request['inbox_id'];
        $data['message'] = $request['chat_message'];
        $data['to_id'] = $request['to_id'];
        $data['from_id'] = $request['from_id'];
        $data['type'] = config('constants.notification_type.new_message_receive');
        $requestDetails=$this->chat->getRequestId($request['inbox_id']);
        $data['request_id'] = $requestDetails['request_id'];
        sendPushNotification($data, $userIds);
        // ************************Push Notifications*******************************
        return true;
        //
    }


    /**
     * send message
     *
     * @return \Illuminate\Http\Response
     */

    public function saveMessage(Request $request)
    {
        try {
            $data['from_id'] = $request['fromUser'];
            $data['inbox_id'] = $request['inboxId'];
            $data['message'] = $request['message'];
            $chats = $this->chat->sendMessage($data);
            return response()->json(['success' => true, 'error' => [], 'data' =>  $chats]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
