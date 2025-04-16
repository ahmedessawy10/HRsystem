<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Observers\AttendObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // ...existing event listeners...
    ];

    /**
     * Register any events for your application.
     */
    protected function boot(array $events): void
    {
        // Register the Attendance observer
        Attendance::observe(AttendObserver::class);
    }
}