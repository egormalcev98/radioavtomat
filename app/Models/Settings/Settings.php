<?php

namespace App\Models\Settings;

use App\Models\BaseModel;

class Settings extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
	];
	
	/**
     * Получим текущие настройки для системы
	 */
	public function scopeCurrent($query)
	{
		return $query->first();
	}
	
}
