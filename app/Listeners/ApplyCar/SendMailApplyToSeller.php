<?php

namespace App\Listeners\ApplyCar;

use App\Mail\ToUser\CarApplied;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailApplyToSeller
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $buyer = User::find($event->order->user_id);
        try {
            Mail::to($buyer->email)->send(new CarApplied());
        }catch (\Exception $e){
            \Log::error($e);
        }
    }
}
