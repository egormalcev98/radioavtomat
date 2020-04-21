<?php

namespace App\Services\Main;

use App\Models\Settings\Settings;
use App\Models\References\StructuralUnit;
use App\User;

class MainService
{	
	/**
	 * Настройки
	 */
	public function settings() 
	{
        if(\Schema::hasTable(app(Settings::class)->getTable())){
			return Settings::first();
		}
		
		return null;
	}
	
	/**
	 * Отделы
	 */
	public function structuralUnits() 
	{
		if(\Schema::hasTable(app(StructuralUnit::class)->getTable())){
			return StructuralUnit::orderedGet();
		}
	}
	
	/**
	 * Пользователи/Сотрудники
	 */
	public function users() 
	{
		if(\Schema::hasTable(app(User::class)->getTable())){
			return User::withoutAdmin()->orderBy('surname')->get();
		}
	}
}