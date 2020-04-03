<?php

namespace App\Http\Controllers\References;

use App\Models\References\OutgoingDocStatus;
use App\Services\References\OutgoingDocStatusService as Service;
use App\Http\Requests\References\BaseRequest;

class OutgoingDocStatusController extends ReferenceController
{
	public function __construct(Service $service) {
		parent::__construct($service);
	}
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\OutgoingDocStatus  $outgoingDocStatus
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, OutgoingDocStatus $outgoingDocStatus)
    {
        return $this->ajaxUpdateElement($request, $outgoingDocStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\OutgoingDocStatus  $outgoingDocStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutgoingDocStatus $outgoingDocStatus)
    {
        return $this->destroyElement($outgoingDocStatus);
    }
}
