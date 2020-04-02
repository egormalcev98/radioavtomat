<?php

namespace App\Services\References;

use App\Models\References\IncomingDocStatus;
use DataTables;

class IncomingDocStatusService extends ReferenceService
{	
	public $routeName = 'incoming_doc_statuses';
	
	public $translation = 'references.incoming_doc_statuses.';
	
	public function __construct()
    {
        parent::__construct(IncomingDocStatus::query());
    }
}