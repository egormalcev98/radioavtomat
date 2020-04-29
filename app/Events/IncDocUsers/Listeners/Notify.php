<?php

namespace App\Events\IncDocUsers\Listeners;

use App\Events\IncDocUsers\IncDocUserNotifications;
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
     * @param  IncDocUserNotifications  $event
     * @return void
     */
    public function handle(IncDocUserNotifications $event)
    {
		$mainService = app(\App\Services\Main\MainService::class);
		
		$mainService->userNotify([
			'user_id' => $event->incomingDocumentUser->user_id
		]);
    }
}
