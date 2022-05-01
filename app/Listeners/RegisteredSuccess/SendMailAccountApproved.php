<?php

namespace App\Listeners\RegisteredSuccess;

use App\Mail\ToUser\RegisterApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailAccountApproved
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
            Mail::to($event->user->email)->send(new RegisterApproved($event->user->company_name));
        }catch (\Exception $e){
            \Log::error($e);
        }
    }
}
