<?php

namespace App\Events\Notes\Listeners;

use App\Events\Notes\NoteNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Notify
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NoteNotifications  $event
     * @return void
     */
    public function handle(NoteNotifications $event)
    {
        $item = $event->note;
		$mainService = app(\App\Services\Main\MainService::class);
		
		$params = [
			'user_id' => $item->user_id
		];
		
		if($item->wasRecentlyCreated) {
			$params['send_email'] = [
				'text' => 'Новая служебная записка: '  . $item->title,
				'url' => route('notes.edit', $item->id)
			];
		}
		
		$mainService->userNotify($params);
    }
}
