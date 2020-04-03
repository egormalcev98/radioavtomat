<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use App\Role;
use App\Services\References\RoleService as Service;
use App\Http\Requests\References\RoleRequest;

class RoleController extends Controller
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
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        return $this->ajaxUpdateElement($request, $role);
    }

}
