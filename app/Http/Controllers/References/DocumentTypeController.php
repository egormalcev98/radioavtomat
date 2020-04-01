<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use App\Models\References\DocumentType;
use Illuminate\Http\Request;
use App\Services\References\DocumentTypeService as Service;

class DocumentTypeController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		// $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index', 'show']]);
        // $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store']]);
        // $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update', 'permissionsSave']]);
        // $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['edit', 'permissions']]);
        // $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentType $documentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentType $documentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentType $documentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentType $documentType)
    {
        //
    }
}
