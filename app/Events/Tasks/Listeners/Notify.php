<?php

namespace App\Events\Tasks\Listeners;

use App\Events\Tasks\TaskNotifications;
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
     * @param  TaskNotifications  $event
     * @return void
     */
    public function handle(TaskNotifications $event)
    {
        $item = $event->task;
		$mainService = app(\App\Services\Main\MainService::class);
		
		$idUsers = $item->users->pluck('id')->toArray();
		
		if(!empty($idUsers)) {
					
			$params = [
				'user_id' => $idUsers
			];
			
			$mainService->userNotify($params);
		}
    }
}
