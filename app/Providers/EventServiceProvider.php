<?php

namespace App\Providers;

use App\Events\ApplyCar;
use App\Events\PostCar;
use App\Events\PostCarResult;
use App\Events\RegisteredSuccess;
use App\Events\SendContact;
use App\Events\SendMessage;
use App\Events\UpdateCar;
use App\Listeners\ApplyCar\NotifyApplyToSeller;
use App\Listeners\ApplyCar\SendMailApplyToSeller;
use App\Listeners\PostCar\SendMailPostCarToAdmin;
use App\Listeners\PostCar\SendMailPostCarToSeller;
use App\Listeners\PostCarResult\SendMailResultToSeller;
use App\Listeners\Registered\SendMailRegisterComplete;
use App\Listeners\Registered\SendMailToAdmin;
use App\Listeners\RegisteredSuccess\SendMailAccountApproved;
use App\Listeners\SendContact\SendMailContactComplete;
use App\Listeners\SendMessage\NotifyToMessageReceiver;
use App\Listeners\SendMessage\SendMailNewMessageToReceiver;
use App\Listeners\UpdateCar\SendMailUpdateCarToAdmin;
use App\Listeners\UpdateCar\SendMailUpdateCarToSeller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            // SendEmailVerificationNotification::class,
            // SendMailRegisterComplete::class,
            // SendMailToAdmin::class
        ],
        RegisteredSuccess::class => [
            SendMailAccountApproved::class
        ],
        PostCar::class => [
            SendMailPostCarToAdmin::class,
            SendMailPostCarToSeller::class
        ],
        PostCarResult::class => [
            SendMailResultToSeller::class,
        ],
        UpdateCar::class => [
            SendMailUpdateCarToAdmin::class,
            SendMailUpdateCarToSeller::class
        ],
        SendContact::class => [
            SendMailContactComplete::class
        ],
        ApplyCar::class => [
            SendMailApplyToSeller::class,
            NotifyApplyToSeller::class
        ],
        SendMessage::class => [
            NotifyToMessageReceiver::class,
            SendMailNewMessageToReceiver::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
