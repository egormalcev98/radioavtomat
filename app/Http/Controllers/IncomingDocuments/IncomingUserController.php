<?php

namespace App\Http\Controllers\IncomingDocuments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\IncomingDocuments\IncomingDocumentDistributed;
use App\Models\IncomingDocuments\IncomingDocumentResponsible;
use App\Services\IncomingDocuments\IncomingUserService as Service;
use App\Http\Requests\IncomingDocuments\SaveUserRequest;
use App\Http\Requests\IncomingDocuments\SignedRequest;

class IncomingUserController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		$this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['listDistributed', 'listResponsibles']]);
	}
	
	public function listDistributed(IncomingDocument $incomingDocument)
    {
		if (request()->ajax()) {
			return $this->service->dataTableDataDistributed($incomingDocument);
		}
		
		return abort(404);
    }
	
    public function saveDistributed(SaveUserRequest $request, IncomingDocument $incomingDocument)
    {
		if ($request->ajax() and $this->service->checkEditDistributed($incomingDocument->id)) {
			
			$this->service->saveDistributed($request, $incomingDocument);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(403);
    }
	
    public function destroyDistributed(IncomingDocumentDistributed $incomingDocumentDistributed)
    {
		if (request()->ajax() and $this->service->checkEditDistributed($incomingDocumentDistributed->incoming_document_id)) {
			
			$this->service->destroyDistributed($incomingDocumentDistributed);
			return $this->serverResponseDestroy();
		}
		
		return abort(403);
    }
	
	public function listResponsibles(IncomingDocument $incomingDocument)
    {
		if (request()->ajax()) {
			return $this->service->dataTableDataResponsibles($incomingDocument);
		}
		
		return abort(404);
    }
	
    public function saveResponsible(SaveUserRequest $request, IncomingDocument $incomingDocument)
    {
		if ($request->ajax() and $this->service->checkEditResponsibles($incomingDocument->id)) {
			
			$this->service->saveResponsible($request, $incomingDocument);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(403);
    }
	
    public function destroyResponsible(IncomingDocumentResponsible $incomingDocumentResponsible)
    {
		if (request()->ajax() and $this->service->checkEditResponsibles($incomingDocumentResponsible->incoming_document_id)) {
			return $this->destroyElement($incomingDocumentResponsible);
		}
		
		return abort(403);
    }
	
    public function signed(SignedRequest $request, IncomingDocument $incomingDocument)
    {
		if ($request->ajax()) {
			
			$this->service->saveSigned($request, $incomingDocument);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(403);
    }
	
}
