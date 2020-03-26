<?php

namespace App\Services\Settings;

use App\Services\BaseService;
use App\User;
use DataTables;
use App\Models\References\UserStatus;
use App\Models\References\StructuralUnit;

class UserService extends BaseService
{	
	public $templatePath = 'crm.settings.users.';
	
	public $templateForm = 'form';
	
	public $routeName = 'users';
	
	public $translation = 'users.';
	
	public function __construct()
    {
        parent::__construct(User::query());
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
	// public function tableColumns() 
	// {
		// return [
			// [
				// 'title' => __($this->translation . 'list_columns.id'),
				// 'data' => 'id',
			// ],
			// [
				// 'title' => __($this->translation . 'list_columns.name'),
				// 'data' => 'name',
			// ],
			
			// $this->actionButton()
		// ];
	// }
	
	/**
	 * Данные для работы с элементом
	 */
	public function elementData($user = null) 
	{
		$userStatuses = UserStatus::orderedGet();
		$structuralUnits = StructuralUnit::orderedGet();
		
		return compact('user', 'userStatuses', 'structuralUnits');
	}
	
}