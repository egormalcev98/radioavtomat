<?php

namespace App\Models\Chat;

use App\Models\BaseModel;

class ChatMessage extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'text',
		'to_user_id',
		'structural_unit_id',
	];
}
