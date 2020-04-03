<?php

namespace App\Services\References;

use App\Models\References\EventType;
use DataTables;

class EventTypeService extends ReferenceService
{	
	public $routeName = 'event_types';
	
	public $translation = 'references.event_types.';
	
	public function __construct()
    {
        parent::__construct(EventType::query());
    }
}