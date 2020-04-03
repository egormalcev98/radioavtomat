<?php

namespace App\Http\Controllers\References;

use App\Models\References\StatusNote;
use App\Services\References\StatusNoteService as Service;
use App\Http\Requests\References\BaseRequest;

class StatusNoteController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\StatusNote  $statusNote
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, StatusNote $statusNote)
    {
        return $this->ajaxUpdateElement($request, $statusNote);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\StatusNote  $statusNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusNote $statusNote)
    {
        return $this->destroyElement($statusNote);
    }
}
