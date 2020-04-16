<?php

namespace App\Services\Settings;

use App\Services\BaseService;
use App\User;
use App\Role;
use App\Permission;
use DataTables;
use App\Models\References\UserStatus;
use App\Models\References\StructuralUnit;

class UserService extends BaseService
{	
	public $templatePath = 'crm.settings.users.';
	
	public $templateForm = 'form';
	
	public $routeName = 'users';
	
	public $translation = 'users.';
	
	public $permissionKey = 'user';
	
	public $model;
	
	public function __construct()
    {
        parent::__construct(User::withoutGlobalScope('active')->withoutAdmin());
    }

	/**
     * Варианты доступов к модулям, аккуратно со свойством map, условия по нему необходимо менять и при выводе данных и при записи (elementData, syncPermissions)
     */
	protected $permissionTypes = [
		'closed' => [
			'title' => 'permissions.types.closed',
			'map' => [], // отсутствие доступов
		],
		'opened' => [
			'title' => 'permissions.types.opened',
			'map' => true, // в данном случае копируем карту доступов из конфига laratrust_seeder 
		],
		'reading' => [
			'title' => 'permissions.types.reading',
			'map' => [
				'read',
				'view',
			], // укажем конкретно какие разрешения нужны для данного варианта
		],
	];

	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$routeName = $this->routeName;
		$roles = Role::withoutAdmin()->get();
		$structuralUnits = StructuralUnit::orderedGet();
		
		return compact('routeName', 'roles', 'structuralUnits');
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
		
		// Фильтры
		
		if (request()->has('role') and request()->role) {
			$query->whereRoleIs(request()->role);
		}
		
		if (request()->has('structural_unit') and request()->structural_unit) {
			$query->where('structural_unit_id', request()->structural_unit);
		}
		
		//////////////////
		
		return Datatables::of($query)
				->addColumn('action', $this->actionColumnDT())
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
	public function userPermissionsData() 
	{
		$user = $this->model;
		
		$permissionModules = config('permission.modules');
		$permissionTypes = $this->permissionTypes;
		
		$userPermissions = $this->model->permissions;
		$laratrustSeeder = config('laratrust_seeder');
		$permissionMap = array_values($laratrustSeeder['permissions_map']);
		
		if(!empty($permissionModules) and !empty($userPermissions)) {
			foreach($permissionModules as $key => $module) {
				foreach($permissionTypes as $type => $typeData) {
					if($typeData['map'] === true) {
						$typeData['map'] = $this->collectSpecificPermissionsMap($module['name']);
					}
					
					$permissions = $userPermissions->whereIn('name', $this->collectPermissionsMap($module['name'], $permissionMap))
													->pluck('name')
													->toArray();
									
					$typeData['map'] = $this->collectPermissionsMap($module['name'], $typeData['map']);
					
					sort($typeData['map']);
					sort($permissions);
					
					if(implode("", $typeData['map']) == implode("", $permissions)) {
						$permissionModules[$key]['list_types'] = $type;
						// break;
					}
				}
			}
		}
		
		return compact('user', 'permissionModules', 'permissionTypes');
	}
	
	/**
     * Метод создания или обновления разрешений роли
     */
	public function userPermissionsSave($request)
	{
		$requestAll = $request->all();
		$arrSync = [];
		
		$arrSync = $this->model
			 ->permissions()
			 ->where('name', 'like', "read_incoming_doc\_%")		
			 ->get()
			 ->pluck('id')
			 ->toArray();
		
		if(!empty($requestAll['permission_modules'])) {
			$permissionModules = config('permission.modules');
			$permissionTypes = $this->permissionTypes;
			
			foreach($permissionModules as $module) {
				if(isset($requestAll['permission_modules'][$module['name']])) {
					$type = $requestAll['permission_modules'][$module['name']];
					
					if(isset($permissionTypes[$type]) and !empty($permissionTypes[$type]['map'])) {
						
						if($permissionTypes[$type]['map'] === true) {
							$arrayPermissions = $this->collectSpecificPermissionsMap($module['name']);
						} else {
							$arrayPermissions = $permissionTypes[$type]['map'];
						}
						
						$permissions = Permission::whereIn('name', $this->collectPermissionsMap($module['name'], $arrayPermissions))
												->get()
												->pluck('id')
												->toArray();
						
						if(!empty($permissions)) {
							$arrSync = array_merge($arrSync, $permissions);
						}
					}
					
				}
			}
		}
		
		$this->model
			 ->permissions()
			 ->sync($arrSync);
		
		$this->model->flushCache();
		
		return true;
	}

	private function collectPermissionsMap($module, $permissionsMap)
	{
		$array = [];
		
		if(!empty($permissionsMap)) {
			foreach($permissionsMap as $key => $permission) {
				$array[$key] = $permission . '_' . $module;
			}
		}
		
		return $array;
	}

	private function collectSpecificPermissionsMap($module)
	{
		$permissionStructure = config('laratrust_seeder.permission_structure');
		$permissionsMap = config('laratrust_seeder.permissions_map');
		$array = [];
		
		if(!empty($permissionStructure)) {
			foreach($permissionStructure as $permission) {
				if(isset($permission[$module])) {
					
					$arrayMap = explode(",", $permission[$module]);
					foreach($arrayMap as $permissionKey) {
						if(isset($permissionsMap[trim($permissionKey)])) {
							$array[$permissionsMap[trim($permissionKey)]] = $permissionsMap[trim($permissionKey)];
						}
					}
					
				}
			}
		}
		
		return $array;
	}
}