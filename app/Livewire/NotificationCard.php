<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationCard extends Component
{
    public $count;
    public $notifications;

    protected $listeners = ['refreshNotifications' => 'refreshNotificationCount'];

    public function mount()
    {
        $this->refreshNotificationCount();
    }

    public function refreshNotificationCount()
    {
        $this->count = Auth::user()->unreadNotifications->count();
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function render()
    {
        return view('livewire.notification-card');
    }

    // Add method to mark notifications as read
    public function markAsRead($notificationId)
    {
        Auth::user()
            ->notifications
            ->where('id', $notificationId)
            ->first()
            ->markAsRead();

        $this->refreshNotificationCount();
    }
}
