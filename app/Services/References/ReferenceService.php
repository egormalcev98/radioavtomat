<?php

namespace App\Services\References;

use App\Services\BaseService;
use DataTables;

class ReferenceService extends BaseService
{	
	public $templatePath = 'crm.references.';
	
	public $templateForm = 'main_form';
	
	public $permissionKey = 'references';
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$templateElement = $this->templatePath . $this->templateForm;
		$action = route($this->routeName . '.store');
		
		return compact('templateElement', 'action');
	}
	
	/**
	 * Сформируем колонку "Действие" для DataTable
	 */
	protected function actionColumnDT()
	{
		return function ($element){
			$routeName = $this->routeName;
			
			return view('crm.references.action_buttons', compact('element', 'routeName'));
		};
	}
}