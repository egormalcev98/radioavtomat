<?php

namespace App\Services\Chat;

use App\Models\Chat\ChatMessage;

class ChatService
{	
	public $routeName = 'chat';
	
	public $permissionKey = '';
	
	/**
	 * Обновление записи в БД
	 */
	public function saveMessage($request) 
	{
		$requestAll = $request->all();
		
		$newMessage = auth()->user()
			  ->sentChatMessages()
			  ->create($requestAll);
		
		try {
			broadcast(new \App\Events\Chat\NewMessage(
				[
					'text' => $newMessage->text,
				], 
				auth()->user()->id,
				$newMessage
			));
		} catch (\Exception $e) {}
		
		return true;
	}
}