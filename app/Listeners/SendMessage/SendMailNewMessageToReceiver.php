<?php

namespace App\Listeners\SendMessage;

use App\Events\SendMessage;
use App\Mail\ToUser\NewMessage;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailNewMessageToReceiver
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
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
        $receiver = User::find($receiverId);
        $sender  = User::find($senderId);
        try {
            Mail::to($receiver->email)->send(new NewMessage($sender->company_name, $event->chatRoom->id));
        }catch (\Exception $e){
            \Log::error($e);
        }
    }
}
