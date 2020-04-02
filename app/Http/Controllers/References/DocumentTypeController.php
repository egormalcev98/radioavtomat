<?php

namespace App\Http\Controllers\References;

use App\Models\References\DocumentType;
use App\Services\References\DocumentTypeService as Service;
use App\Http\Requests\References\BaseRequest;

class DocumentTypeController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, DocumentType $documentType)
    {
        return $this->ajaxUpdateElement($request, $documentType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentType $documentType)
    {
        return $this->destroyElement($documentType);
    }
}
