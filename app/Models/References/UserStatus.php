<?php

namespace App\Models\References;

use App\Models\BaseModel;

class UserStatus extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
	];
}
