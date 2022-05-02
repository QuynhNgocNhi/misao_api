<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SendMessageRequest;
use App\Http\Requests\User\Chat\SendRequest;
use App\Models\ChatRoom;
use App\Services\Api\ChatService;
use Illuminate\Http\Request;

class BaseApiChatController extends ApiController
{
    public function __construct(private ChatService $chatService)
    {
    }

    public function room(Request $request)
    {
        $params = [
            'order_chat_room_id' => $request->chat_room_id,
        ];
        if ($request->type == 1) {
            $params['buyer_id'] = $this->auth()->id();
        } else {
            $params['seller_id'] = $this->auth()->id();
        }

        $rooms = $this->chatService->getRooms($params, 20);

        return $this->json($rooms);
    }

    public function message($id, Request $request)
    {
        $lastId = $request->last_id;
        $params = [
            'chat_room_id' => $id,
            'last_id' => $lastId,
        ];

        $data = $this->chatService->getMessages($params, $this->auth()->user(), 50);

        if (!$data) {
            return $this->json([], '404', 404);
        }

        $page = $request->page;
        if (!$lastId && !($page > 1)) {
            $room = $this->chatService->showRoom($id);
            $room->load(['product.images', 'buyRequest.images']);
            $data = $data->toArray();
            // $data['car'] = $room->order?->car;
            //TODO: check logic
        }

        return $this->json($data);
    }

    public function send($id, SendMessageRequest $request)
    {
        $params = $request->validated();
        $params['chat_room_id'] = $id;
        $message = $this->chatService->sendMessage($params, $this->auth()->user());

        return $this->json($message);
    }

    protected function auth()
    {
        return auth('user');
    }
}
