<?php

namespace App\Http\Controllers\IncomingDocuments;

use App\Http\Controllers\Controller;
use App\Models\IncomingDocuments\IncomingDocument;
use Illuminate\Http\Request;
use App\Services\IncomingDocuments\IncomingDocumentService as Service;
use App\Http\Requests\IncomingDocuments\CheckNumberRequest;
use App\Http\Requests\IncomingDocuments\StoreRequest;
use App\Http\Requests\IncomingDocuments\UpdateRequest;

class IncomingDocumentController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		$this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
        $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store', 'checkNumber']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update']]);
        $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['edit']]);
        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);
		
		$this->middleware('permission:view_incoming_card_document', ['only' => ['show']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeElement($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomingDocuments\IncomingDocument  $incomingDocument
     * @return \Illuminate\Http\Response
     */
    public function show(IncomingDocument $incomingDocument)
    {
        return $this->showElement($incomingDocument);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomingDocuments\IncomingDocument  $incomingDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomingDocument $incomingDocument)
    {
        return $this->editElement($incomingDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomingDocuments\IncomingDocument  $incomingDocument
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, IncomingDocument $incomingDocument)
    {
        return $this->updateElement($request, $incomingDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomingDocuments\IncomingDocument  $incomingDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomingDocument $incomingDocument)
    {
        return $this->destroyElement($incomingDocument);
    }
	
    /**
     * Проверка номера нового документа на существование в БД
     */
    public function checkNumber(CheckNumberRequest $request)
    {
        if ($request->ajax()) {
			
			return $this->ajaxSuccessResponse(__($this->service->translation . 'messages.check_number_success'));
		}
		
		return abort(403);
    }
}
