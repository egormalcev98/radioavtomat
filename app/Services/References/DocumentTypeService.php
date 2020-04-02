<?php

namespace App\Services\References;

use App\Models\References\DocumentType;
use DataTables;

class DocumentTypeService extends ReferenceService
{	
	public $routeName = 'document_types';
	
	public $translation = 'references.document_types.';
	
	public function __construct()
    {
        parent::__construct(DocumentType::query());
    }
}