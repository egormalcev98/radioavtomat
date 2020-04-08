<?php

namespace App\Http\Requests\IncomingDocuments;

use Illuminate\Validation\Rule;

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
		
		$arrayRules['number'] = [
			'required',
			'integer',
			Rule::unique('incoming_documents', 'number')
				->ignore($this->incoming_document),
		];
		$arrayRules['register'] = 'required|integer';
		$arrayRules['scan_files.*'] = $arrayRules['new_scan_files.*'];
		
		return $arrayRules;
    }
}
