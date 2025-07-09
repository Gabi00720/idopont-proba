<?php

namespace App\Providers;

use Backstage\TwoFactorAuth\Listeners\SendTwoFactorCodeListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Events\TwoFactorAuthenticationEnabled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen([
            TwoFactorAuthenticationChallenged::class,
            TwoFactorAuthenticationEnabled::class
        ], SendTwoFactorCodeListener::class);
    }
}
