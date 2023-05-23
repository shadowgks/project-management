<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messanger', function () {
    // return City::findOrNew(1);
    return json_encode([
        'message' => 'yoooo test from channels'
    ]);
});

Broadcast::channel('test_event', function () {
    // return City::findOrNew(1);
    return json_encode([
        'message' => 'yoooo test from channels'
    ]);
});
