<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\StoreRequest;
use App\Http\Requests\Notes\UpdateRequest;
use App\Models\Notes\Note;
use App\Services\Notes\NoteService as Service;

class NoteController extends Controller
{
    public function __construct(Service $service)
    {
        $this->service = $service;

        $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
        $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['edit', 'update']]);
        $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['show']]);
        $this->middleware('permission:delete_any_' . $this->service->permissionKey, ['only' => ['destroy']]);

        $this->middleware('note_owner', ['only' => ['edit', 'update']]);

        view()->share('permissionKey', $this->service->permissionKey);

    }

    public function show(Note $note)
    {
        return $this->showElement($note)
            ->with([
                'method' => 'show',
                'action' => route($this->service->routeName . '.edit', $note->id),
            ]);
    }

    public function store(StoreRequest $request)
    {
        return $this->storeElement($request);
    }

    public function edit(Note $note)
    {

        return $this->editElement($note);
    }

    public function update(UpdateRequest $request, Note $note)
    {
        return $this->updateElement($request, $note);
    }

    public function destroy(Note $note)
    {
        return $this->destroyElement($note);
    }

}
