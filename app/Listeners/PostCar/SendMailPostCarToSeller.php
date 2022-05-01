<?php

namespace App\Listeners\PostCar;

use App\Mail\ToUser\CarPosted;
use Illuminate\Support\Facades\Mail;

class SendMailPostCarToSeller
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
            Mail::to(auth()->user()->email)->send(new CarPosted());
        }catch (\Exception $e){
            \Log::error($e);
        }
    }
}
