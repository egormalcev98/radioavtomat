<?php

namespace App\Services\IncomingDocuments;

use App\Services\BaseService;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\IncomingDocStatus;
use App\Models\References\DocumentType;
use App\User;
use DataTables;

class IncomingDocumentService extends BaseService
{	
	public $templatePath = 'crm.incoming_documents.';
	
	public $templateForm = 'form';
	
	public $routeName = 'incoming_documents';
	
	public $translation = 'incoming_documents.';
	
	public $permissionKey = 'incoming_document';
	
	public function __construct()
    {
        parent::__construct(IncomingDocument::query());
    }

	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		// $routeName = $this->routeName;
		// $roles = Role::withoutAdmin()->get();
		// $structuralUnits = StructuralUnit::orderedGet();
		
		// return compact('routeName', 'roles', 'structuralUnits');
	}
	
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
			[
				'title' => __($this->translation . 'list_columns.title'),
				'data' => 'title',
			],
			
			$this->actionButton()
		];
	}
	
	/**
	 * Данные для работы с элементом
	 */
	public function elementData() 
	{
		if(is_object($this->model) === false)
			$incomingDocument = $this->model;

		$incomingDocStatuses = IncomingDocStatus::orderedGet();
		$documentTypes = DocumentType::orderedGet();
		$recipients = User::withoutAdmin()->get();
		
		return compact('incomingDocument', 'incomingDocStatuses', 'documentTypes', 'recipients');
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	/*public function dataTableData()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'name';
		$select[] = 'middle_name';
		
		$query = $this->model
					->select( $select )
					->with(['structuralUnit', 'roles', 'status']);
		
		// Фильтры
		
		if (request()->has('role') and request()->role) {
			$query->whereRoleIs(request()->role);
		}
		
		if (request()->has('structural_unit') and request()->structural_unit) {
			$query->where('structural_unit_id', request()->structural_unit);
		}
		
		//////////////////
		
		return Datatables::of($query)
				->addColumn('action', function ($element){
					$routeName = $this->routeName;
					
					return view('crm.action_buttons', compact('element', 'routeName'));
				})
				->addColumn('showUrl', function ($element) {
					return route($this->routeName . '.show', $element->id);
				})
				->addColumn('fullName', function ($element) {
					return $element->fullName;
				})
				->addColumn('buttonPermissions', function ($element) {
					return view($this->templatePath . 'list_columns.permissions', compact('element', 'routeName'));
				})
				->make(true);
	}*/
	
	/**
	 * Создание записи в БД
	 */
	// public function store($request) 
	// {
		// $requestAll = $request->all();
		
		// $this->model = $this->model->create($requestAll);
		
		// $this->model->attachRole($requestAll['role']);
		// $this->model->save();
		
		// return true;
	// }
	
	/**
	 * Обновление записи в БД
	 */
	// public function update($request) 
	// {
		// $requestAll = $request->all();
		
		// if(!$requestAll['password']){
			// unset($requestAll['password']);
		// }
		
		// $this->model->roles()->sync([ $requestAll['role'] ]);
		
		// $this->model->update($requestAll);
		
		// return true;
	// }
}