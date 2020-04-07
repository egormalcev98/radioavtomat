<?php

namespace App\Http\Controllers\OutgoingDocuments;

use App\Http\Controllers\Controller;
//use App\Models\OutgoingDocuments\OutgoingDocument;
use App\Models\OutgoingDocuments\OutgoingDocument;
use App\User;
use Illuminate\Http\Request;
use App\Services\OutgoingDocuments\OutgoingDocumentService as Service;

//use App\Http\Requests\Settings\UpdateRequest;

class OutgoingDocumentController extends Controller
{
    public function __construct(Service $service)
    {
        $this->service = $service;

        $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index', 'show']]);
        $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update', 'permissionsSave']]);
        $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['edit', 'permissions']]);
        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);

        view()->share('permissionKey', $this->service->permissionKey);

    }

    /**
     * Display the specified resource.
     *
     * @param OutgoingDocument $outgoingDocument
     * @return \Illuminate\Http\Response
     */
    public function show(OutgoingDocument $outgoingDocument)
    {
        return $this->showElement($outgoingDocument);
    }

}
