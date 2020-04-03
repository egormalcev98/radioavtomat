<?php

namespace App\Services\References;

use App\Models\References\UserStatus;
use DataTables;

class UserStatusService extends ReferenceService
{	
	public $routeName = 'user_statuses';
	
	public $translation = 'references.user_statuses.';
	
	public function __construct()
    {
        parent::__construct(UserStatus::query());
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