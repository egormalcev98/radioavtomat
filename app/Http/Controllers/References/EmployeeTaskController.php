<?php

namespace App\Http\Controllers\References;

use App\Models\References\EmployeeTask;
use App\Services\References\EmployeeTaskService as Service;
use App\Http\Requests\References\BaseRequest;

class EmployeeTaskController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\EmployeeTask  $employeeTask
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, EmployeeTask $employeeTask)
    {
        return $this->ajaxUpdateElement($request, $employeeTask);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\EmployeeTask  $employeeTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeTask $employeeTask)
    {
        return $this->destroyElement($employeeTask);
    }
}
