<?php

namespace App\Services\References;

use App\Models\References\TaskStatus;
use DataTables;

class TaskStatusService extends ReferenceService
{	
	public $routeName = 'task_statuses';
	
	public $translation = 'references.task_statuses.';
	
	public function __construct()
    {
        parent::__construct(TaskStatus::query());
    }
}