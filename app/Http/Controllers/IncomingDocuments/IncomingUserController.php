<?php

namespace App\Http\Controllers\IncomingDocuments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\IncomingDocuments\IncomingDocumentDistributed;
use App\Models\IncomingDocuments\IncomingDocumentResponsible;
use App\Services\IncomingDocuments\IncomingUserService as Service;
use App\Http\Requests\IncomingDocuments\SaveUserRequest;

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
		
		//Роли укажи кто может создавать распределенных
	}
	
	public function listDistributed()
    {
		if (request()->ajax()) {
			return $this->service->dataTableDataDistributed();
		}
		
		return abort(404);
    }
	
    public function saveDistributed(SaveUserRequest $request, IncomingDocument $incomingDocument)
    {
		if ($request->ajax()) {
			
			$this->service->saveDistributed($request, $incomingDocument);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(403);
    }
	
    public function destroyDistributed(IncomingDocumentDistributed $incomingDocumentDistributed)
    {
		return $this->destroyElement($incomingDocumentDistributed);
    }
	
	public function listResponsibles()
    {
		if (request()->ajax()) {
			return $this->service->dataTableDataResponsibles();
		}
		
		return abort(404);
    }
	
    public function saveResponsible(SaveUserRequest $request, IncomingDocument $incomingDocument)
    {
		if ($request->ajax()) {
			
			$this->service->saveResponsible($request, $incomingDocument);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(403);
    }
	
    public function destroyResponsible(IncomingDocumentResponsible $incomingDocumentResponsible)
    {
		return $this->destroyElement($incomingDocumentResponsible);
    }
	
}
