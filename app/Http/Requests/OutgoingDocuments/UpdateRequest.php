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
        $arrayRules['scan_files.*'] = $arrayRules['new_scan_files.*'];

		return $arrayRules;
    }
}
