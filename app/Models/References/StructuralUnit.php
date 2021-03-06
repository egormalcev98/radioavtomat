<?php

namespace App\Models\References;

use App\Models\BaseModel;
use App\User;

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

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
