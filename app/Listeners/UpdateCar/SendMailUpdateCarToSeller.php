<?php

namespace App\Listeners\UpdateCar;

use App\Mail\ToUser\CarPosted;
use App\Mail\ToUser\CarUpdated;
use Illuminate\Support\Facades\Mail;

class SendMailUpdateCarToSeller
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
            Mail::to(auth()->user()->email)->send(new CarUpdated());
        }catch (\Exception $e){
            \Log::error($e);
        }
    }
}
