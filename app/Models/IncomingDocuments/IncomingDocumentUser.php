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
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
		'sign_up',
		'signed_at',
		'reject_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];
	
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'type',
		'sign_up',
		'signed_at',
		'reject_at',
		'comment',
		'employee_task_id',
		'user_id',
	];
}
