<?php

namespace App\Listeners\Registered;

use App\Mail\ToAdmin\NewUserRegister;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailToAdmin
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
        $admins = Admin::select('email')->get();
        try {
            Mail::to($admins)->send(new NewUserRegister($event->user));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }
}
