<?php

namespace App\Services\Settings;

use App\Models\Settings\Settings;

class SettingsService
{	
	public $templatePath = 'crm.settings.';
	
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
		
		return compact('settings');
	}
	
	/**
	 * Обновление записи в БД
	 */
	public function updateRecording($request) 
	{
		// $requestAll = $request->all();
		
		// if($this->settings) {
			// $this->settings->update($requestAll);
		// } else {
			// $this->settings = Settings::create($requestAll);
		// }
		
		
		// if(isset($requestAll['logo']) and $requestAll['logo']) {
			// $this->settings->logo = $request->file('logo')->store('settings', 'public');
			// $this->settings->save();
		// }
		
		// if(isset($requestAll['background_image']) and $requestAll['background_image']) {
			// $this->settings->background_image = $request->file('background_image')->store('settings', 'public');
			// $this->settings->save();
		// }
		
		return true;
	}
}