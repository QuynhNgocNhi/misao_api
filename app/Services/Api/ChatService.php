<?php

namespace App\Services\Api;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use App\Repositories\ChatMessageRepository;
use App\Repositories\ChatRoomRepository;
use App\Services\FileService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Exception;

class ChatService
{

    public function __construct(
        private ChatRoomRepository    $chatRoomRepository,
        private ChatMessageRepository $chatMessageRepository,
        private FileService           $fileService,
    ) {
    }

    public function getRooms(array $params = [], $limit = PER_PAGE)
    {
        $whereEquals = [
            'buyer_id'  => Arr::get($params, 'buyer_id', null),
            'seller_id' => Arr::get($params, 'seller_id', null),
        ];

        $whereLikes = [];
        $sorts      = [];
        $roomId     = Arr::get($params, 'order_chat_room_id', null);
        if ($roomId) {
            $sorts[] = "raw|id=${roomId}:DESC";
        }

        $params = [
            'where_equals' => $whereEquals,
            'where_likes'  => $whereLikes,
            'sort'         => Arr::get($params, 'sort', 'updated_at:desc'),
            'sorts'        => $sorts,
            'relates'      => ['buyer', 'seller', 'product.images', 'buyRequest.images', 'last_message'],
        ];

        return $limit > 0 ? $this->chatRoomRepository->paginate($params, $limit) : $this->chatRoomRepository->get($params);
    }

    public function showRoom($id)
    {
        return $this->chatRoomRepository->find($id);
    }

    public function getMessages(array $params, User $user, $limit = PER_PAGE)
    {
        $roomId = Arr::get($params, 'chat_room_id', null);
        $userId = $user->id;
        $room   = $this->showRoom($roomId);
        if (!$room || !($room->seller_id == $userId || $room->buyer_id == $userId)) {
            return false;
        }

        $whereEquals = [
            'chat_room_id' => Arr::get($params, 'chat_room_id', null),
        ];

        $lastId = Arr::get($params, 'last_id', null);
        $params = [
            'where_equals' => $whereEquals,
            'sort'         => 'id:desc',
            'last_id'      => $lastId,
        ];

        if ($lastId) {
            return $this->chatMessageRepository->get($params);
        }

        $page = request()->page;
        if (!$lastId && !($page > 1)) {
            $this->updateReadAt($room, $userId);
        }

        return $limit > 0 ? $this->chatMessageRepository->paginate($params, $limit) : $this->chatMessageRepository->get($params);
    }

    public function sendMessage(array $params, $user)
    {
        DB::beginTransaction();
        try {
            $sentMessages = [];
            $room    = $this->showRoom($params['chat_room_id'] ?? 0);
            $userId  = $user['id'];
            $data = [];
            $data['chat_room_id'] = $room->id;
            if ($userId == $room->buyer_id) {
                $data['buyer_id'] = $userId;
            } else if ($userId == $room->seller_id) {
                $data['seller_id'] = $userId;
            }
            if (Arr::get($params, 'file', null)) {
                $files = Arr::get($params, 'file', null);
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $saved = $this->fileService->uploadFile($file, '/uploads/chat');
                    $content = $saved['url'];
                    $data['type'] = ChatMessage::TYPE_IMAGE;
                    $data['content'] = $content;
                    $message = $this->chatMessageRepository->create($data);
                    array_push($sentMessages, $message);
                }
            }
            if (Arr::get($params, 'content', '')) {
                $data['type'] = ChatMessage::TYPE_TEXT;
                $data['content'] = Arr::get($params, 'content', '');
                $message = $this->chatMessageRepository->create($data);
                array_push($sentMessages, $message);
            }
            $this->updateUnread($room, $userId, true);
            DB::commit();
            return $sentMessages;
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);

            return false;
        }
    }

    public function updateUnread(ChatRoom $room, $userId, $timestamps = false)
    {
        $seenAt = [];
        if ($userId == $room->buyer_id) {
            $seenAt['seller_read_at'] = null;
        }
        if ($userId == $room->seller_id) {
            $seenAt['buyer_read_at'] = null;
        }
        $this->chatRoomRepository->updateWithTimestamp($room->id, $seenAt, $timestamps);
    }

    public function updateReadAt(ChatRoom $room, $userId, $timestamps = false)
    {
        $seenAt = [];
        if ($userId == $room->buyer_id) {
            $seenAt['buyer_read_at'] = now();
        }
        if ($userId == $room->seller_id) {
            $seenAt['seller_read_at'] = now();
        }
        $this->chatRoomRepository->updateWithTimestamp($room->id, $seenAt, $timestamps);
    }

    public function getTotalRoomUnread($userId, $type)
    {
        return $this->chatRoomRepository->getTotalUnread($userId, $type);
    }
}
