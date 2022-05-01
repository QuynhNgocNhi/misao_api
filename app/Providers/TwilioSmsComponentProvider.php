<?php

namespace App\Providers;

use App\Components\Twilio\SmsComponent;
use Illuminate\Support\ServiceProvider;

class TwilioSmsComponentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton(SmsComponent::class, function($app) {
//            return new SmsComponent();
//        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return array
     */
    public function provides()
    {
//        return [SmsComponent::class];
        return [];
    }
}
