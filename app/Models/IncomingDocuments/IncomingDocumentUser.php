<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;

class IncomingDocumentUser extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incoming_document_users';
	
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
	];
}
