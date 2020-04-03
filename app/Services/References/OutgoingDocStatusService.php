<?php

namespace App\Services\References;

use App\Models\References\OutgoingDocStatus;
use DataTables;

class OutgoingDocStatusService extends ReferenceService
{	
	public $routeName = 'outgoing_doc_statuses';
	
	public $translation = 'references.outgoing_doc_statuses.';
	
	public function __construct()
    {
        parent::__construct(OutgoingDocStatus::query());
    }
}