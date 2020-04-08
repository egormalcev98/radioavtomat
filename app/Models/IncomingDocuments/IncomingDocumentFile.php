<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;

class IncomingDocumentFile extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'file_path',
	];
}
