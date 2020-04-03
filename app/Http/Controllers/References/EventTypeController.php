<?php

namespace App\Http\Controllers\References;

use App\Models\References\EventType;
use App\Services\References\EventTypeService as Service;
use App\Http\Requests\References\BaseRequest;

class EventTypeController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, EventType $eventType)
    {
        return $this->ajaxUpdateElement($request, $eventType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        return $this->destroyElement($eventType);
    }
}
