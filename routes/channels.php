<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    // User hanya bisa join channel miliknya sendiri
    return (int) $user->id === (int) $userId;
});
