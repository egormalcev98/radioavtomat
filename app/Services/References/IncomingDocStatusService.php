<?php

namespace App\Services\References;

use App\Models\References\IncomingDocStatus;
use DataTables;

class IncomingDocStatusService extends ReferenceService
{	
	public $routeName = 'incoming_doc_statuses';
	
	public $translation = 'references.incoming_doc_statuses.';
	
	public function __construct()
    {
        parent::__construct(IncomingDocStatus::query());
    }
	
	/**
	 * Собираем запрос и формируем коллекцию DT
	 */
	protected function constructDataTableQuery()
	{
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'without_destroy';
		
		$query = $this->model
					->select($select);
		
		return Datatables::of($query)
				->addColumn('action', $this->actionColumnDT());
	}
	
	/**
	 * Сформируем колонку "Действие" для DataTable
	 */
	protected function actionColumnDT()
	{
		return function ($element){
			$routeName = $this->routeName;
			
			if($element->without_destroy){
				return view('crm.references.read_button', compact('element', 'routeName'));
			} else {
				return view('crm.references.action_buttons', compact('element', 'routeName'));
			}
		};
	}
}