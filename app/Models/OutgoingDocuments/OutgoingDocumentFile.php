<?php

namespace App\Models\OutgoingDocuments;

use App\Models\BaseModel;

class OutgoingDocumentFile extends BaseModel
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
