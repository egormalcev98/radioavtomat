<?php

namespace App\Http\Controllers\References;

use App\Models\References\IncomingDocStatus;
use App\Services\References\IncomingDocStatusService as Service;
use App\Http\Requests\References\BaseRequest;

class IncomingDocStatusController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\IncomingDocStatus  $incomingDocStatus
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, IncomingDocStatus $incomingDocStatus)
    {
        return $this->ajaxUpdateElement($request, $incomingDocStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\IncomingDocStatus  $incomingDocStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomingDocStatus $incomingDocStatus)
    {
        return $this->destroyElement($incomingDocStatus);
    }
}
