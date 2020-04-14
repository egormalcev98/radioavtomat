<?php

namespace App\Services\IncomingDocuments;

use App\Services\BaseService;
use App\Models\IncomingDocuments\IncomingDocumentDistributed;
use App\Models\IncomingDocuments\IncomingDocumentResponsible;
use DataTables;

class IncomingUserService extends BaseService
{	
	public $routeName = 'incoming_document_users';
	
	public $translation = 'incoming_documents.users.';
	
	public $permissionKey = 'incoming_card_document';
	
	/**
	 * Возвращает список всех колонок для DataTable
	 */
	public function tableColumns() 
	{
		return [
			[
				'title' => __($this->translation . 'list_columns.full_name'),
				'data' => 'user_full_name',
				'name' => 'user_id',
			],
			[
				'title' => __($this->translation . 'list_columns.employee_task_name'),
				'data' => 'employee_task.name',
				'name' => 'employee_task_id',
			],
			[
				'title' => __($this->translation . 'list_columns.comment'),
				'data' => 'comment',
			],
			[
				'title' => __($this->translation . 'list_columns.sign_up'),
				'data' => 'sign_up',
			],
			[
				'title' => __($this->translation . 'list_columns.signed'),
				'data' => 'signed',
				'name' => 'signed_at',
			],
			
			$this->actionButton()
		];
	}
	
	public function constructViewDTDistributed($incomingDocumentId) 
	{
		return $this->constructViewDT()
			->ajax(route($this->routeName . '.list_distributed', $incomingDocumentId));
	}
	
	public function constructViewDTResponsibles($incomingDocumentId) 
	{
		return $this->constructViewDT()
			->ajax(route($this->routeName . '.list_responsibles', $incomingDocumentId));
	}
	
	private function dataTableConstruct($query)
	{
		$query->with(['user', 'employeeTask']);
		
		return Datatables::of($query)
				->addColumn('user_full_name', function ($element) {
					return $element->user->fullName;
				})
				->addColumn('sign_up', function ($element) {
					return $element->some_sign_up;
				})
				->addColumn('signed', function ($element) {
					return view('crm.incoming_documents.users.signed', compact('element'));
				})
				->addColumn('sign_up_date', function ($element) {
					return $element->date_sign_up;
				})
				->addColumn('sign_up_time', function ($element) {
					return $element->time_sign_up;
				})
				->removeColumn('user');
	}
	
	/**
	 * Сформируем колонку "Действие" для DataTable
	 */
	protected function actionColumnDT()
	{
		return '';
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableDataDistributed($incomingDocument)
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'id';
		
		$query = $incomingDocument->distributed()->select( $select );
					
		return $this->dataTableConstruct($query)
					->addColumn('action', function ($element) use($incomingDocument) {
						$routeName = $this->routeName;
						
						return ($this->checkEditDistributed($incomingDocument->id)) ? view('crm.incoming_documents.users.action_buttons_distributed', compact('element', 'routeName')) : '';
					})
					->with([
						'percent_signatures' => $this->percentSignatures($incomingDocument)
					])
					->make(true);
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableDataResponsibles($incomingDocument)
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'id';
		
		$query = $incomingDocument->responsibles()->select( $select );
					
		return $this->dataTableConstruct($query)
					->addColumn('action', function ($element) use($incomingDocument) {
						$routeName = $this->routeName;
						
						return ($this->checkEditResponsibles($incomingDocument->id)) ? view('crm.incoming_documents.users.action_buttons_responsibles', compact('element', 'routeName')) : '';
					})
					->with([
						'percent_signatures' => $this->percentSignatures($incomingDocument)
					])
					->make(true);
	}
	
	public function percentSignatures($incomingDocument)
	{
		$countUsers = $incomingDocument->users()->count();
		$countUsersNotNullSigned = $incomingDocument->users()->whereNotNull('signed_at')->count();
		
		return ($countUsers > 0) ? (( $countUsersNotNullSigned / $countUsers ) * 100) : 0 ;
	}
	
	/**
	 * Сохраним распределителей
	 */
	public function saveDistributed($request, $incomingDocument)
	{	
		$userIds = $this->saveUsers($request, $incomingDocument, 'distributed');
		
		$users = \App\User::whereIn('id', $userIds)->get();
		
		if($users->isNotEmpty()) {
			
			$permission = \App\Permission::firstOrCreate(
				[
					'name' => 'read_incoming_doc_' . $incomingDocument->id,
				],
				[
					'display_name' => 'Доступ к редактированию ответственных во входящем документе №' . $incomingDocument->id,
				]
			);
		
			foreach($users as $user) {
				$user->permissions()->syncWithoutDetaching([ $permission->id ]);
				$user->flushCache();
			}
		}
		
		return true;
	}
	
	/**
	 * Сохраним ответственных
	 */
	public function saveResponsible($request, $incomingDocument)
	{	
		$this->saveUsers($request, $incomingDocument, 'responsibles');
		
		return true;
	}
	
	/**
	 * Сохраним пользователей
	 */
	private function saveUsers($request, $query, $relation)
	{	
		$requestAll = $request->all();
		$userIds = [];
		
		if(!empty($requestAll['select'])) {
			
			foreach($requestAll['select'] as $userId) {
				
				$data = $requestAll['users'][$userId];
				
				$userIds[] = $query->$relation()->updateOrCreate([
					'user_id' => $userId,
					'type' => ($relation == 'distributed') ? 1 : 2,
				], [
					'sign_up' => $data['sign_up_date'] . ' ' . $data['sign_up_time'],
					'comment' => $data['comment'],
					'employee_task_id' => $data['employee_task_id'],
				])->user_id;
			}
		}
		
		return $userIds;
	}
	
	public function checkSignatureUsers($incomingDocument)
	{
		$activeUsers = $incomingDocument->users->pluck('user_id');
		
		return $activeUsers->contains(auth()->user()->id);
	}
	
	public function checkEditDistributed($incomingDocumentId)
	{
		return auth()->user()->hasRole(['secretary', 'admin']);
	}
	
	public function checkEditResponsibles($incomingDocumentId)
	{
		return auth()->user()->can('read_incoming_doc_' . $incomingDocumentId) or auth()->user()->hasRole(['admin']);
	}
	
	/**
	 * Сохраним подпись пользователя
	 */
	public function saveSigned($request, $incomingDocument)
	{	
		$requestAll = $request->all();
		
		$incomingDocument->users()
						->where('user_id', auth()->user()->id)
						->update([
							$requestAll['signed'] . '_at' => $requestAll[$requestAll['signed'] . '_at_date'] . ' ' . $requestAll[$requestAll['signed'] . '_at_time'],
							($requestAll['signed'] == 'reject') ? 'signed_at' : 'reject_at' => null,
						]);
		
		return true;
	}
	
}