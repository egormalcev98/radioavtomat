<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;

class IncomingDocumentUser extends BaseModel
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
