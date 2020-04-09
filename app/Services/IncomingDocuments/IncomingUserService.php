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
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableDataDistributed()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		
		$query = IncomingDocumentDistributed::select( $select );
					
		return $this->dataTableConstruct($query);
	}
	
}