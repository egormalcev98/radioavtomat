<?php

namespace App\Models\References;

use App\Models\BaseModel;

class EventType extends BaseModel
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
