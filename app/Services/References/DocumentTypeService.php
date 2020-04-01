<?php

namespace App\Services\References;

use App\Services\BaseService;
use App\Models\References\DocumentType;
use DataTables;

class DocumentTypeService extends BaseService
{	
	public $templatePath = 'crm.references.';
	
	public $templateForm = 'main_form';
	
	public $routeName = 'document_types';
	
	public $translation = 'references.document_types.';
	
	public $permissionKey = 'references';
	
	public $model;
	
	public function __construct()
    {
        parent::__construct(DocumentType::query());
    }
}