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
	
	public $permissionKey = 'incoming_document';
	
	// public function __construct()
    // {
        // parent::__construct(IncomingDocumentUser::query());
    // }

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
		return $this->constructViewDT()->ajax(route($this->routeName . '.list_distributed', $incomingDocumentId));
	}
	
	public function constructViewDTResponsibles($incomingDocumentId) 
	{
		return $this->constructViewDT()->ajax(route($this->routeName . '.list_responsibles', $incomingDocumentId));
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
	public function dataTableDataDistributed()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'id';
		
		$query = IncomingDocumentDistributed::select( $select );
					
		return $this->dataTableConstruct($query)
					->addColumn('action', function ($element){
						$routeName = $this->routeName;
						
						return view('crm.incoming_documents.users.action_buttons_distributed', compact('element', 'routeName'));
					})
					->make(true);
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableDataResponsibles()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'id';
		
		$query = IncomingDocumentResponsible::select( $select );
					
		return $this->dataTableConstruct($query)
					->addColumn('action', function ($element){
						$routeName = $this->routeName;
						
						return view('crm.incoming_documents.users.action_buttons_responsibles', compact('element', 'routeName'));
					})
					->make(true);
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
				$user->permissions()->sync([ $permission->id ]);
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
	
	
}