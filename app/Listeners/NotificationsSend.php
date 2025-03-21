<?php

namespace App\Listeners;

use App\Events\Notifications;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationsSend
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Notifications $event): void
    {
        // Add logging to track notification sending
        Log::info('Sending notification to user: ' . $event->user->id);
        
        // Create new notification instance
        $notification = new NewNotification($event->message);
        
        // Send notification
        $event->user->notify($notification);
    }
}
