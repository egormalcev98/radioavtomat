<?php

namespace App\Http\Controllers\IncomingDocuments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IncomingDocuments\IncomingUserService as Service;

class IncomingUserController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		// $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index', 'show']]);
        // $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store']]);
        // $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update', 'permissionsSave']]);
        // $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['edit', 'permissions']]);
        // $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);
		
		// view()->share('permissionKey', $this->service->permissionKey);
	}
	
	public function listDistributed()
    {
		if (request()->ajax()) {
			return $this->service->dataTableDataDistributed();
		}
		
		return abort(404);
    }
}
