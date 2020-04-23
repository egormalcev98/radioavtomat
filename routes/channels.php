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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
   return (int) $user->id === (int) $id;
});

/*
Broadcast::channel('chat_user.{id}', function ($user, $id) {
	// dd($user, $id);
   return (int) $user->id === (int) $id;
});*/

Broadcast::channel('chat-user.{oneUserId}.{twoUserId}', function ($user, $oneUserId, $twoUserId) {
    return (int) $user->id === (int) $oneUserId or (int) $user->id === (int) $twoUserId;
});