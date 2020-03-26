<?php

namespace App\Models\References;

use App\Models\BaseModel;

class StructuralUnit extends BaseModel
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
