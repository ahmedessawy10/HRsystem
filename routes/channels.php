<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('typing.{typerId}', function ($user, $typerId) {
    return true;
});

Broadcast::channel('notification.{userid}', function (int $userid) {
    return $userid === Auth::id();
});
