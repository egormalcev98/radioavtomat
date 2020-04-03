<?php

namespace App\Services\References;

use App\Models\References\StructuralUnit;
use DataTables;

class StructuralUnitService extends ReferenceService
{	
	public $routeName = 'structural_units';
	
	public $translation = 'references.structural_units.';
	
	public function __construct()
    {
        parent::__construct(StructuralUnit::query());
    }
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$templateElement = $this->templatePath . $this->templateForm;
		
		return compact('templateElement');
	}
	
	/**
	 * Сформируем колонку "Действие" для DataTable
	 */
	protected function actionColumnDT()
	{
		return function ($element){
			$routeName = $this->routeName;
			
			return view('crm.references.read_button', compact('element', 'routeName'));
		};
	}
}