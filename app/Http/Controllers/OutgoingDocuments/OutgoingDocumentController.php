<?php

namespace App\Http\Controllers\OutgoingDocuments;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutgoingDocuments\CheckNumberRequest;
use App\Http\Requests\OutgoingDocuments\StoreRequest;
use App\Http\Requests\OutgoingDocuments\UpdateRequest;
use App\Models\OutgoingDocuments\OutgoingDocument;
use Illuminate\Http\Request;
use App\Services\OutgoingDocuments\OutgoingDocumentService as Service;

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

    public function show(OutgoingDocument $outgoingDocument)
    {
        return $this->showElement($outgoingDocument)
            ->with([
                'method' => 'show',
                'action' => route($this->service->routeName . '.edit', $outgoingDocument->id),
            ]);
    }

    public function store(StoreRequest $request)
    {
        return $this->storeElement($request);
    }

    public function edit(OutgoingDocument $outgoingDocument)
    {

        return $this->editElement($outgoingDocument);
    }

    public function update(UpdateRequest $request, OutgoingDocument $outgoingDocument)
    {
        return $this->updateElement($request, $outgoingDocument);
    }

    public function destroy(OutgoingDocument $outgoingDocument)
    {
        return $this->destroyElement($outgoingDocument);
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
