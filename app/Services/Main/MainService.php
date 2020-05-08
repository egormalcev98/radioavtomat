<?php

namespace App\Services\Main;

use App\Models\Settings\Settings;
use App\Models\References\StructuralUnit;
use App\User;
use App\Models\IncomingDocuments\IncomingDocumentUser;
use App\Models\Tasks\Task;
use App\Models\Notes\Note;
use Carbon\Carbon;

class MainService
{
	/**
	 * Настройки
	 */
	public function settings()
	{
        if(\Schema::hasTable(app(Settings::class)->getTable())){
			return Settings::first();
		}

		return null;
	}

	/**
	 * Отделы
	 */
	public function structuralUnits()
	{
		if(\Schema::hasTable(app(StructuralUnit::class)->getTable())){
			return StructuralUnit::orderedGet();
		}
	}

	/**
	 * Пользователи/Сотрудники
	 */
	public function users()
	{
		if(\Schema::hasTable(app(User::class)->getTable())){
			return User::/*withoutAdmin()->*/orderBy('surname')->get();
		}
	}

	/**
	 * Получим необходимые данные для уведомлений
	 */
	public function dataNotifications($userId = null)
	{
		if(!\Schema::hasTable(app(IncomingDocumentUser::class)->getTable()) or !auth()->check()){
			return null;
		}

		if(!$userId) {
			$userId = auth()->id();
		}

		$list = IncomingDocumentUser::where('user_id', $userId)
					->has('incomingDocument')
					->with('incomingDocument')
					->whereNull('signed_at')
					->whereNull('reject_at')
					->limit(20)
					->orderBy('sign_up', 'asc')
					->groupBy('incoming_document_id')
					->get()
					->map(function ($item, $key) {
						$data = [];
						$data['url'] = route('incoming_documents.show', $item->incoming_document_id);
						$data['title_notification'] = $item->incomingDocument->title;
						$data['date'] = $item->sign_up;

						return $data;
					});

		$listTasks = Task::whereIn('task_status_id', [1,3])
					->with(['taskType'])
					->whereHas('users', function ($user) use($userId){
						return $user->whereNull('completed')
							->where('id', $userId);
					})
					->limit(20)
					->orderBy('end', 'asc')
					->get()
					->map(function ($item, $key) {
						$data = [];
						$data['url'] = route('tasks.index');
						$data['title_notification'] = $item->taskType->name . ': ' . $item->text;
						$data['date'] = Carbon::parse($item->end);

						return $data;
					});

		if($list->isNotEmpty()) {
			$notifications = $list->merge($listTasks);
		} else {
			$notifications = $listTasks;
		}

		$listNotes = Note::where('user_id', $userId)
					->limit(20)
					->where('status_note_id', '!=', 3)
					->orderBy('created_at', 'asc')
					->get()
					->map(function ($item, $key) {
						$data = [];
						$data['url'] = route('notes.show', $item->id);
						$data['title_notification'] = $item->title;
						$data['date'] =  Carbon::parse($item->created_at);

						return $data;
					});

		if(isset($notifications)) {
			$notifications = $notifications->toBase()->merge($listNotes);
		} else {
			$notifications = $listNotes;
		}

		$notifications = $notifications->sortBy('date')->values();

		return $notifications;
	}

	/**
	 * Обновим события пользователя на лету и отправим сообщение на почту если это нужно. А так же напишем в чат
	 */
	public function userNotify($arrayData)
	{
		if(isset($arrayData['user_id'])) {

			if(!is_array($arrayData['user_id'])) {
				$arrayData['user_id'] = [ $arrayData['user_id'] ];
			}

			foreach($arrayData['user_id'] as $userId) {

				try {
					broadcast(new \App\Events\Notifications\UpdateBellNotifications(
						[
							'html' => view('crm.notifications.bell')->with([ 'dataNotifications' => $this->dataNotifications($userId) ])->render()
						],
						$userId
					));
				} catch (\Exception $e) { }

				if(isset($arrayData['send_email'])) {
					$user = User::find($userId);

					$details = [
						'text' => $arrayData['send_email']['text'],
						'url' => $arrayData['send_email']['url'],
					];

					\Mail::to($user->email)->queue(new \App\Mail\NotificationMail($details));
				}
			}
		}

		return true;
	}

}
