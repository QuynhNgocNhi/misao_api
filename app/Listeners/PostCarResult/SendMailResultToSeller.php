<?php

namespace App\Listeners\PostCarResult;

use App\Mail\ToUser\CarApprove;
use Illuminate\Support\Facades\Mail;

class SendMailResultToSeller
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->car->user;
        try {
            Mail::to($user->email)->send(new CarApprove($event->car->approve_reason));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }
}
