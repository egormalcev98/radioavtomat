<?php

namespace App\Services\Settings;

use App\Services\BaseService;
use App\User;
use App\Role;
use DataTables;
use App\Models\References\UserStatus;
use App\Models\References\StructuralUnit;

class UserService extends BaseService
{	
	public $templatePath = 'crm.settings.users.';
	
	public $templateForm = 'form';
	
	public $routeName = 'users';
	
	public $translation = 'users.';
	
	public $model;
	
	public function __construct()
    {
        parent::__construct(User::withoutGlobalScope('active')->withoutAdmin());
    }

	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$routeName = $this->routeName;
		
		return compact('routeName');
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
				'title' => __($this->translation . 'list_columns.created_at'),
				'data' => 'created_at',
			],
			[
				'title' => __($this->translation . 'list_columns.full_name'),
				'data' => 'fullName',
				'name' => 'surname',
			],
			[
				'title' => __($this->translation . 'list_columns.structural_unit'),
				'data' => 'structural_unit.name',
				'name' => 'structural_unit_id',
			],
			[
				'title' => __($this->translation . 'list_columns.role'),
				'data' => 'roles.0.display_name',
				'remove_select' => true,
				'searchable' => false,
				'orderable' => false,
			],
			[
				'title' => __($this->translation . 'list_columns.email'),
				'data' => 'email',
			],
			[
				'title' => __($this->translation . 'list_columns.status'),
				'data' => 'status.name',
				'name' => 'user_status_id',
			],
			[
				'title' => __($this->translation . 'list_columns.permissions'),
				'data' => 'buttonPermissions',
				'remove_select' => true,
				'searchable' => false,
				'orderable' => false,
			],
			
			$this->actionButton()
		];
	}
	
	/**
	 * Данные для работы с элементом
	 */
	public function elementData() 
	{
		$user = $this->model;
		$userStatuses = UserStatus::orderedGet();
		$structuralUnits = StructuralUnit::orderedGet();
		$roles = Role::withoutAdmin()->get();
		
		return compact('user', 'userStatuses', 'structuralUnits', 'roles');
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableData()
	{	
		$select = $this->columnsToSelect( $this->tableColumns() );
		$select[] = 'name';
		$select[] = 'middle_name';
		
		$query = $this->model
					->select( $select )
					->with(['structuralUnit', 'roles', 'status']);
		
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
	}
	
	/**
	 * Создание записи в БД
	 */
	public function store($request) 
	{
		$requestAll = $request->all();
		
		$this->model = $this->model->create($requestAll);
		
		$this->model->attachRole($requestAll['role']);
		$this->model->save();
		
		return true;
	}
	
	/**
	 * Обновление записи в БД
	 */
	public function update($request) 
	{
		$requestAll = $request->all();
		
		if(!$requestAll['password']){
			unset($requestAll['password']);
		}
		
		$this->model->roles()->sync([ $requestAll['role'] ]);
		
		$this->model->update($requestAll);
		
		return true;
	}
	
	/**
	 * Данные по разрешениям для элемента
	 */
	public function elementPermissionsData() 
	{
		$user = $this->model;
		
		return compact('user');
	}
	
}