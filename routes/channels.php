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

Broadcast::channel('chat-user.{oneUserId}.{twoUserId}', function ($user, $oneUserId, $twoUserId) {
    return (int) $user->id === (int) $oneUserId or (int) $user->id === (int) $twoUserId;
});

Broadcast::channel('chat-structural-unit.{channelId}', function ($user, $channelId) {
    // return (int) $user->structural_unit_id === (int) $channelId or $user->hasRole('admin');
	return isset($user->id);
});

Broadcast::channel('chat-general', function ($user) {
	return isset($user->id);
});