<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('typing.{typerId}', function (User $user, $typerId) {
    return true;
});

Broadcast::channel('notification.{userid}', function (User $user, $userid) {
    return $userid === $user->id;
});
