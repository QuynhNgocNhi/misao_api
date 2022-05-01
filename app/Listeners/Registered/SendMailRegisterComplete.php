<?php

namespace App\Listeners\Registered;

use App\Mail\ToUser\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailRegisterComplete
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
        try {
            Mail::to($event->user->email)->send(new Registered($event->user->company_name));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }
}
