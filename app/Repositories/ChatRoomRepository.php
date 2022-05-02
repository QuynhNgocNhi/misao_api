<?php

namespace App\Repositories;

use App\Models\ChatRoom;

class ChatRoomRepository extends BaseRepository {

    function modelName(): string
    {
        return ChatRoom::class;
    }

    public function getTotalUnread($userId, $type)
    {

        $query = $this->getModel()
                      ->query()
                      ->where(function ($subQuery) use ($type) {
                          if ($type == TYPE_BUYER) {
                              $subQuery->orWhereNull('buyer_read_at');
                          } else {
                              $subQuery->orWhereNull('seller_read_at');
                          }

                          $subQuery->whereHas('last_message', function ($subQuery) use ($type) {
                              if ($type == TYPE_BUYER) {
                                  $subQuery->whereRaw('chat_messages.created_at > chat_rooms.buyer_read_at');
                              } else {
                                  $subQuery->whereRaw('chat_messages.created_at > chat_rooms.seller_read_at');
                              }

                          });
                      });

        if ($type == 1) {
            $query->where('buyer_id', $userId);
        } else {
            $query->where('seller_id', $userId);
        }

        return $query->count();
    }

}
