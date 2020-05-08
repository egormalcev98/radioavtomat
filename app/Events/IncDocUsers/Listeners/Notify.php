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
		$item = $event->incomingDocumentUser;
		$mainService = app(\App\Services\Main\MainService::class);
		
		$params = [
			'user_id' => $item->user_id
		];
		
		if($item->wasRecentlyCreated) {
			$params['send_email'] = [
				'text' => 'Ожидает рассмотрения входящий документ: '  . $item->incomingDocument->title,
				'url' => route('incoming_documents.show', $item->incoming_document_id)
			];
		}
		
		$mainService->userNotify($params);
    }
}
