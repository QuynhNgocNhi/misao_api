<?php

namespace App\Listeners\ApplyCar;

use App\Events\ApplyCar;
use App\Services\Api\AccountService;
use App\Services\Api\NotificationService;
use OneSignal;

class NotifyApplyToSeller
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private AccountService      $accountService,
                                private NotificationService $notificationService,)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ApplyCar $event
     * @return void
     */
    public function handle(ApplyCar $event)
    {
        $chatRoom = $this->getChatRoom($event->order->id);
        $buyer    = $this->getInfoBuyer($event->order->user_id);
        $title    = '在庫確認・商談申込を受け付けました。';
        $message = $buyer->company_name . 'から申込があります。';

        // create notification to seller
        $noti = $this->notificationService->create([
            'title'   => $title,
            'content' => $message,
            'status'  => NOTIFICATION_STATUS['PUBLIC'],
            'user_id' => $event->order->user_sell_id
        ]);
        $noti->users()->attach($event->order->user_sell_id);

        //Push to one signal
        OneSignal::sendNotificationToExternalUser(
            message: $message,
            data: [
                'chat_room_id' => $chatRoom->id,
                'car_id' => $event->order->car_id,
                'room_type' => 'seller',
            ],
            userId: (string)$event->order->user_sell_id,
            headings: $title
        );
    }

    private function getInfoBuyer($userId)
    {
        return $this->accountService->show($userId);
    }

    private function getChatRoom($orderId)
    {
        return \DB::table('chat_rooms')->where('order_id', $orderId)->first();
    }
}
