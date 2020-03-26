<?php

namespace App\Services\Settings;

use App\Models\Settings\Settings;
use App\User;

class SettingsService
{	
	public $templatePath = 'crm.settings.general.';
	
	public $templateForm = 'index';
	
	public $routeName = 'settings';
	
	public $translation = 'settings.';
	
	public function __construct()
    {
        $this->model = Settings::first();
    }

	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$settings = $this->model;
		$routeName = $this->routeName;
		$admin = User::select(['id', 'email'])->admin();
		
		return compact('settings', 'routeName', 'admin');
	}
	
	/**
	 * Обновление записи в БД
	 */
	public function update($request) 
	{
		$requestAll = $request->all();
		
		if($this->model) {
			$this->model->update($requestAll);
		} else {
			$this->model = Settings::create($requestAll);
		}
		
		if(isset($requestAll['logo_img']) and $requestAll['logo_img']) {
			$this->model->logo_img = $request->file('logo_img')->store('settings', 'public');
			$this->model->save();
		}
		
		if(isset($requestAll['background_img']) and $requestAll['background_img']) {
			$this->model->background_img = $request->file('background_img')->store('settings', 'public');
			$this->model->save();
		}
		
		$admin = User::admin();
		$admin->email = $requestAll['admin']['email'];
		
		if($requestAll['admin']['password']) {
			$admin->password = $requestAll['admin']['password'];
		}
		
		$admin->save();
		
		return true;
	}
}