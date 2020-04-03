<?php

namespace App\Http\Controllers\References;

use App\Models\References\CategoryNote;
use App\Services\References\CategoryNoteService as Service;
use App\Http\Requests\References\BaseRequest;

class CategoryNoteController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\CategoryNote  $categoryNote
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, CategoryNote $categoryNote)
    {
        return $this->ajaxUpdateElement($request, $categoryNote);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\CategoryNote  $categoryNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryNote $categoryNote)
    {
        return $this->destroyElement($categoryNote);
    }
}
