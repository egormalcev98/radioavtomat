<?php

namespace App\Services\IncomingDocuments;

use App\Services\BaseService;
use App\Models\IncomingDocuments\IncomingDocumentDistributed;
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
				'title' => __($this->translation . 'list_columns.id'),
				'data' => 'id',
			],
			
			$this->actionButton()
		];
	}
	
	public function constructViewDTDistributed($incomingDocumentId) 
	{
		return $this->constructViewDT()->ajax(route($this->routeName . '.list_distributed', $incomingDocumentId));
	}
	
	private function dataTableConstruct($query)
	{
		// $query->with(['structuralUnit', 'roles', 'status']);
		
		return Datatables::of($query)
				->addColumn('action', $this->actionColumnDT())
				->make(true);
	}
	
	/**
	 * Сформируем колонку "Действие" для DataTable
	 */
	protected function actionColumnDT()
	{
		return function ($element){
			$routeName = $this->routeName;
			return '';
			// return view('crm.action_buttons', compact('element', 'routeName'));
		};
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableDataDistributed()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		
		$query = IncomingDocumentDistributed::select( $select );
					
		return $this->dataTableConstruct($query);
	}
	
	/**
	 * Сохраним пользователей
	 */
	public function saveDistributed($request, $incomingDocument)
	{	
		return $this->saveUsers($request, $incomingDocument, 'distributed');
	}
	
	/**
	 * Сохраним пользователей
	 */
	private function saveUsers($request, $query, $relation)
	{	
		$requestAll = $request->all();
		
		if(!empty($requestAll['select'])) {
			
			foreach($requestAll['select'] as $userId) {
				
				$data = $requestAll['users'][$userId];
				
				$query->$relation()->updateOrCreate([
					'user_id' => $userId,
					'type' => ($relation == 'distributed') ? 1 : 2,
				], [
					'sign_up' => $data['sign_up_date'] . ' ' . $data['sign_up_time'],
					'comment' => $data['comment'],
					'employee_task_id' => $data['employee_task_id'],
				]);
			}
		}
		
		return true;
	}
	
	
}