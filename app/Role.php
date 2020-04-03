<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
	/**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'display_name',
	];
	
	/**
     * Исключить админа
     */
	public function scopeWithoutAdmin($query)
    {
        return $query->where('name', '!=','admin');
    }
}
