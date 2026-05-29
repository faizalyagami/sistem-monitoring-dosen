<?php

namespace App\Providers;

use App\Helpers\ActivityHelper;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Event::listen(Login::class, function ($event) {
            ActivityHelper::logLogin($event->user);
        });

        Event::listen(Logout::class, function ($event) {
            ActivityHelper::logLogout($event->user);
        });
    }
}
