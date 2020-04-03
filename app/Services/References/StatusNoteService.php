<?php

namespace App\Services\References;

use App\Models\References\StatusNote;
use DataTables;

class StatusNoteService extends ReferenceService
{	
	public $routeName = 'status_notes';
	
	public $translation = 'references.status_notes.';
	
	public function __construct()
    {
        parent::__construct(StatusNote::query());
    }
}