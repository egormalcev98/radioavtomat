<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use App\Models\References\UserStatus;
use App\Services\References\UserStatusService as Service;
use App\Http\Requests\References\BaseRequest;

class UserStatusController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		$this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
			return $this->service->dataTableData();
		}
		
		$with = $this->service->outputData();
		
		$with['title'] = __($this->service->translation . 'index.title');
		$with['datatable'] = $this->service->constructViewDT();
		
		return view($this->service->templatePath . 'listelements')->with($with);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\UserStatus  $userStatus
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, UserStatus $userStatus)
    {
        return $this->ajaxUpdateElement($request, $userStatus);
    }

}
