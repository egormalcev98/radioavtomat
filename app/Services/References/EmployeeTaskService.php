<?php

namespace App\Services\References;

use App\Models\References\EmployeeTask;
use DataTables;

class EmployeeTaskService extends ReferenceService
{	
	public $routeName = 'employee_tasks';
	
	public $translation = 'references.employee_tasks.';
	
	public function __construct()
    {
        parent::__construct(EmployeeTask::query());
    }
}