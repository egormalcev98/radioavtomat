<?php

namespace App\Http\Controllers\References;

use App\Models\References\TaskStatus;
use App\Services\References\TaskStatusService as Service;
use App\Http\Requests\References\BaseRequest;

class TaskStatusController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, TaskStatus $taskStatus)
    {
        return $this->ajaxUpdateElement($request, $taskStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        return $this->destroyElement($taskStatus);
    }
}
