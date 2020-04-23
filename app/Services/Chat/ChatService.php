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
	
	/**
	 * Сохраним выбранный пользователем канал и получим список последних сообщений
	 */
	public function saveChannelAndGetMessages($request, $LimitMsg = 70) 
	{
		$accessTypes = [
			'users' => 'to_user_id',
			'structural_units' => 'structural_unit_id',
		];
		
		if($request->type and !isset($accessTypes[$request->type])) {
			return [];
		}
		
		$user = auth()->user();
		
		$messages = ChatMessage::select(['text', 'sender_user_id'])
					->with([
						'senderUser' => function($query) {
							$query->select([
								'id',
								'surname',
								'name',
							]);
						}
					]);
		
		if(!isset($request->type) or !$request->type) {
			$user->chat_channel = null;
			$messages->whereNull('to_user_id')
					->whereNull('structural_unit_id');
		} else {
			$user->chat_channel = [
				'type' => $request->type,
				'id' => $request->id,
			];
			
			$messages->where($accessTypes[$request->type], (int) $request->id);
		}
		
		$user->save();
		
		return $messages->limit($LimitMsg)->get();
	}
}