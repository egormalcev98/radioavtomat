<?php

namespace App\Services\IncomingDocuments;

use App\Services\BaseService;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\IncomingDocStatus;
use App\Models\References\DocumentType;
use App\Models\References\EmployeeTask;
use App\User;
use DataTables;
use App\Services\IncomingDocuments\IncomingUserService;

class IncomingDocumentService extends BaseService
{	
	public $templatePath = 'crm.incoming_documents.';
	
	public $templateForm = 'form';
	
	public $routeName = 'incoming_documents';
	
	public $translation = 'incoming_documents.';
	
	public $permissionKey = 'incoming_document';
	
	protected $incomingUserService;
	
	public function __construct(IncomingUserService $incomingUserService)
    {
        parent::__construct(IncomingDocument::query());
		
		$this->incomingUserService = $incomingUserService;
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
	
	public function checkViewResponse()
	{
		return auth()->user()->hasRole(['secretary', 'admin']);
	}
	
	/**
	 * Данные для работы с элементом
	 */
	public function elementData() 
	{
		$incomingDocStatuses = IncomingDocStatus::orderedGet();
		$documentTypes = DocumentType::orderedGet();
		$recipients = User::withoutAdmin()->get();
		
		if(class_basename($this->model) != 'Builder') {
			$incomingDocument = $this->model;
			$incomingDocumentFiles = $incomingDocument->files()->orderedGet();
			$viewResponse = $this->checkViewResponse();
			
			$datatableDistributed = $this->incomingUserService->constructViewDTDistributed($this->model->id);
			
			$employees = $recipients;
			$employeeTasks = EmployeeTask::orderedGet();
		}
		
		return compact(
			'incomingDocument', 
			'incomingDocStatuses', 
			'documentTypes', 
			'recipients', 
			'incomingDocumentFiles', 
			'viewResponse', 
			'datatableDistributed', 
			'employees',
			'employeeTasks'
		);
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableData()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		
		$query = $this->model
					->select( $select );
					// ->with(['structuralUnit', 'roles', 'status']);
		
		// Фильтры
		
		// if (request()->has('role') and request()->role) {
			// $query->whereRoleIs(request()->role);
		// }
		
		// if (request()->has('structural_unit') and request()->structural_unit) {
			// $query->where('structural_unit_id', request()->structural_unit);
		// }
		
		//////////////////
		
		return Datatables::of($query)
				->addColumn('action', $this->actionColumnDT())
				->addColumn('showUrl', function ($element) {
					return route($this->routeName . '.show', $element->id);
				})
				->make(true);
	}
	
	/**
	 * Создание записи в БД
	 */
	public function store($request) 
	{
		$requestAll = $request->all();
		
		$requestAll = $this->preliminaryPreparation($requestAll);
		
		if(isset($requestAll['register_automatic'])) {
			$lastDoc = IncomingDocument::latest()->first();
			$requestAll['register'] = $lastDoc ? ($lastDoc->register + 1) : 1;
		}
		
		$this->model = $this->model->create($requestAll);
		
		$this->furtherPreparation($requestAll);
		
		return true;
	}
	
	private function preliminaryPreparation($requestAll)
	{
		if(isset($requestAll['urgent'])) {
			$requestAll['urgent'] = 1;
		} else {
			$requestAll['urgent'] = null;
		}
		
		if(isset($requestAll['original_received'])) {
			$requestAll['original_received'] = 1;
		} else {
			$requestAll['original_received'] = null;
		}
		
		return $requestAll;
	}
	
	private function furtherPreparation($requestAll)
	{
		$notDestroyFiles = [];
		
		if(isset($requestAll['new_scan_files']) and !empty($requestAll['new_scan_files'])) {
			foreach($requestAll['new_scan_files'] as $newFile) {
				$fileSave = $newFile->store('incoming_documents', 'public');
				
				$notDestroyFiles[] = $this->model->files()->create([
					'name' => $newFile->getClientOriginalName(),
					'file_path' => $fileSave,
				])->id;
			}
		}
		
		if(isset($requestAll['isset_sf']) and !empty($requestAll['isset_sf'])) {
			$getFiles = $this->model
				->files()
				->whereIn('id', array_flip($requestAll['isset_sf']))
				->get();
		
			foreach($getFiles as $file) {
				$notDestroyFiles[] = $file->id;
				
				if(isset($requestAll['scan_files']) and isset($requestAll['scan_files'][$file->id])) {
					$replaceFile = $requestAll['scan_files'][$file->id];
					$replaceFileSave = $replaceFile->store('incoming_documents', 'public');
				
					$file->update([
						'name' => $replaceFile->getClientOriginalName(),
						'file_path' => $replaceFileSave,
					]);
				} else {
				
					if($file->name != $requestAll['isset_sf'][$file->id]) {
						$file->update([
							'name' => $requestAll['isset_sf'][$file->id]
						]);
					}
				}
			}
		}
		
		if(empty($notDestroyFiles)) {
			$this->model
				->files()
				->delete();
		} else {
			$this->model
				->files()
				->whereNotIn('id', $notDestroyFiles)
				->delete();
		}
		
		return true;
	}
	
	/**
	 * Обновление записи в БД
	 */
	public function update($request) 
	{
		$requestAll = $request->all();
		
		$requestAll = $this->preliminaryPreparation($requestAll);
		
		$this->model->update($requestAll);
		
		$this->furtherPreparation($requestAll);
		
		return true;
	}
}