<?php

namespace App\Listeners\SendMessage;

use App\Events\SendMessage;
use App\Services\Api\AccountService;
use App\Services\Api\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OneSignal;

class NotifyToMessageReceiver implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private AccountService      $accountService,
                                private NotificationService $notificationService)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SendMessage $event
     * @return void
     */
    public function handle(SendMessage $event)
    {
        $senderId = $event->userId;
        if ($event->userId == $event->chatRoom->buyer_id) {
            $receiverId = $event->chatRoom->seller_id;
            $roomType   = 'buyer';
        } else {
            $receiverId = $event->chatRoom->buyer_id;
            $roomType   = 'seller';
        }
        $sender = $this->getInfoSender($senderId);

        $this->storeNotification($sender, $receiverId);

        OneSignal::sendNotificationToExternalUser(
            message: $sender->company_name . 'からメッセージがあります。',
            data: [
                'chat_room_id' => $event->chatRoom->id,
                'car_id'       => $event->chatRoom->car_id,
                'room_type'    => $roomType,
            ],
            userId: (string)$receiverId,
            headings: '新着メッセージがあります。'
        );
    }

    private function getInfoSender(int $userId)
    {
        return $this->accountService->show($userId);
    }

    private function storeNotification($sender, $receiverId)
    {
        //$urlChatRoom            = route('chat.index', ['chat_room_id' => $room->id]);
        $dataCreateNotification = [
            'title'   => '新着メッセージがあります。',
            'content' => $sender->company_name . 'からメッセージがあります。',
            'user_id' => $receiverId,
            'status'  => ACTIVE
        ];
        $this->notificationService->create($dataCreateNotification);
    }
}
