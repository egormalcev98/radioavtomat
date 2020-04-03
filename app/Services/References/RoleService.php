<?php

namespace App\Services\References;

use App\Role;
use DataTables;

class RoleService extends ReferenceService
{	
	public $routeName = 'roles';
	
	public $translation = 'references.roles.';
	
	public $templateForm = 'role_form';
	
	public function __construct()
    {
        parent::__construct(Role::query());
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
				'title' => __($this->translation . 'list_columns.display_name'),
				'data' => 'display_name',
			],
			
			$this->actionButton()
		];
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