<?php

namespace App\Services\Chat;

use App\User;
use App\Models\Chat\ChatMessage;
use Illuminate\Support\Facades\DB;

class ChatService
{	
	public $routeName = 'chat';
	
	public $permissionKey = '';
	
	private $limitMsg = 10;
	
	/**
	 * Обновление записи в БД
	 */
	public function saveMessage($request) 
	{
		$requestAll = $request->all();
		
		$newMessage = auth()->user()
			  ->sentChatMessages()
			  ->create($requestAll);
			
		$this->eventNewMessage($newMessage, auth()->user());
		
		return true;
	}
	
	public function eventNewMessage($newMessage, $user)
	{
		$user->viewedMessages()->attach($newMessage->id);
		
		try {
			
			if($newMessage->to_user_id) {
				$arrChannelId = [$newMessage->to_user_id, $user->id];
				sort($arrChannelId);
				$channelId = implode('.', $arrChannelId);
				$channelName = 'chat-user.' . $channelId;
				
				$channellMsgCount = [
					'users' => [
						[
							'c_id' => $user->id,
							'count' => 1
						],
					],
				];
				
				broadcast(new \App\Events\Chat\NotifyNewMessage(
					$channellMsgCount,
					[ $newMessage->to_user_id ]
				));
				
			} else {
			
				if($newMessage->structural_unit_id) {
					$channelName = 'chat-structural-unit.' . $newMessage->structural_unit_id;
					
					$channellMsgCount = [
						'structural_units' => [
							[
								'c_id' => $newMessage->structural_unit_id,
								'count' => 1
							],
						],
					];
				}
				
				if(!$newMessage->to_user_id and !$newMessage->structural_unit_id) {
					$channelName = 'chat-general';
					
					$channellMsgCount = [
						'general' => 1,
					];
				}
				
				$idUsersArray = User::get()
							->where('id', '!=', $user->id)
							->pluck('id')
							->toArray();
				
				broadcast(new \App\Events\Chat\NotifyNewMessage(
					$channellMsgCount,
					$idUsersArray
				));
			}
			
			broadcast(new \App\Events\Chat\NewMessage(
				[
					'text' => $newMessage->text,
					'created_at' => $newMessage->created_at,
					'sender_user_id' => $newMessage->sender_user_id,
					'sender_user' => [
						'full_name' => $user->fullName
					],
				], 
				$channelName
			));
		} catch (\Exception $e) {}
		
		return true;
	}
	
	/**
	 * Сохраним выбранный пользователем канал и получим список последних сообщений
	 */
	public function saveChannelAndGetMessages($request) 
	{
		$accessTypes = [
			'users' => 'to_user_id',
			'structural_units' => 'structural_unit_id',
		];
		
		if($request->type and !isset($accessTypes[$request->type])) {
			return [];
		}
		
		$user = auth()->user();
		
		$messages = ChatMessage::select([
							'id', 
							'text', 
							'sender_user_id', 
							'created_at',
						])
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
			
			if($request->type == 'users') {
				$messages->where(function($q) use($request, $user) {
					$q->where('to_user_id', $request->id)->where('sender_user_id', $user->id);
				})
				->orWhere(function($q) use($request, $user) {
					$q->where('to_user_id', $user->id)->where('sender_user_id', $request->id);
				});
			} else {
				$messages->where($accessTypes[$request->type], (int) $request->id);
			}
		}
		
		$user->save();
		
		$page = (int) $request->next_page ?? 0;
		
		$cloneMessages = clone $messages;
		
		$messages = $messages->offset($page * $this->limitMsg)
							->limit($this->limitMsg)
							->orderBy('id', 'desc')
							->get()
							->sortBy('id')
							->values();
		
		$page++;
		
		if($request->read) {
			$this->readMessages(($request->type) ? $accessTypes[$request->type] : null, $request->id);
		}
		
		return [
			'data' => $messages,
			'count_new_messages' => $this->countNewMessages(),
			'pagination' => ($cloneMessages->count() > $page * $this->limitMsg) ? $page : 0,
		];
	}
	
	/**
	 * Получим массив с непрочитанными сообщениями
	 */
	private function countNewMessages()
	{
		$user = auth()->user();
		$countNewMessages = [];
		
		$countNewMessages['users'] = ChatMessage::select([
						DB::raw('sender_user_id AS c_id'),
						DB::raw('COUNT(*) as count'),
					])
					->where('to_user_id', $user->id)
					->has('senderUser')
				    ->whereDoesntHave('viewed', function($query) use($user) {
						return $query->where('user_id', $user->id);
				    })
					->groupBy('sender_user_id')
					->get();
					
		$countNewMessages['structural_units'] = ChatMessage::select([
						DB::raw('structural_unit_id AS c_id'),
						DB::raw('COUNT(*) as count'),
					])
					->has('structuralUnit')
				    ->whereDoesntHave('viewed', function($query) use($user) {
						return $query->where('user_id', $user->id);
				    })
					->groupBy('structural_unit_id')
					->get();
					
		$countNewMessages['general'] = ChatMessage::whereDoesntHave('viewed', function($query) use($user) {
						return $query->where('user_id', $user->id);
				    })
					->whereNull('to_user_id')
					->whereNull('structural_unit_id')
					->count();
					
		return $countNewMessages;
	}
	
	/**
	 * Отметим и сохраним прочитанными сообщения конкретного канала
	 */
	public function saveReadMessages($request)
	{
		$this->readMessages($request->type, $request->id);
		
		try {
			broadcast(new \App\Events\Chat\UpdateCountNewMessages(
				$this->countNewMessages(),
				auth()->user()->id
			));
		} catch (\Exception $e) {}
		
		return true;
	}
	
	/**
	 * Отметим прочитанными сообщения конкретного канала
	 */
	private function readMessages($chatType, $chatId)
	{
		$user = auth()->user();
		
		$messages = ChatMessage::whereDoesntHave('viewed', function($query) use($user) {
						return $query->where('user_id', $user->id);
				    });
		
		if(!isset($chatType) or !$chatType) {
			$messages->whereNull('to_user_id')
					->whereNull('structural_unit_id');
		} else {
			
			if($chatType == 'to_user_id') {
				$messages->where(function($q) use($chatId, $user) {
					$q->where('to_user_id', $user->id)->where('sender_user_id', (int) $chatId);
				});
			} else {
				$messages->where('structural_unit_id', (int) $chatId);
			}
		}
		
		$messages = $messages->limit($this->limitMsg)
							->orderBy('id', 'desc')
							->get()
							->pluck('id')
							->toArray();
							
		if(!empty($messages)) {
			$user->viewedMessages()->attach($messages);
		}
		
		return true;
	}
	
}