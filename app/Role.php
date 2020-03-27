<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
	/**
     * Исключить админа
     */
	public function scopeWithoutAdmin($query)
    {
        return $query->where('name', '!=','admin');
    }
}
