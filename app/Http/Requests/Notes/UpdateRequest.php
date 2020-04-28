<?php

namespace App\Http\Requests\Notes;

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

        $arrayRules['scan_files.*'] = $arrayRules['new_scan_files.*'];
        $arrayRules['created_at'] = '';

		return $arrayRules;
    }
}
