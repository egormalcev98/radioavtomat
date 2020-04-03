<?php

namespace App\Http\Controllers\References;

use App\Models\References\LetterForm;
use App\Services\References\LetterFormService as Service;
use App\Http\Requests\References\BaseRequest;

class LetterFormController extends ReferenceController
{
    public function __construct(Service $service) {
		parent::__construct($service);
	}
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\References\LetterForm  $letterForm
     * @return \Illuminate\Http\Response
     */
    public function update(BaseRequest $request, LetterForm $letterForm)
    {
        return $this->ajaxUpdateElement($request, $letterForm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\References\LetterForm  $letterForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(LetterForm $letterForm)
    {
        return $this->destroyElement($letterForm);
    }
}
