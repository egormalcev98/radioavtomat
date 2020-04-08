<?php

namespace App\Http\Requests\OutgoingDocuments;

class UpdateRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $arrayRules = parent::rules();

        $arrayRules['number'] = 'required|unique:outgoing_documents,number,' . $this->number . ',number|numeric';

		return $arrayRules;
    }
}
