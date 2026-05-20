<?php

namespace App\Providers;

use App\Events\ItemMatchDetected;
use App\Listeners\SendItemMatchNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ItemMatchDetected::class => [
            SendItemMatchNotifications::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
