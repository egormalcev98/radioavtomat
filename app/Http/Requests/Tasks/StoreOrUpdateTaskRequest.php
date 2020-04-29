<?php

namespace App\Http\Requests\Tasks;

class StoreOrUpdateTaskRequest extends StoreOrUpdateOrderRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $arrayRules = parent::rules();

        $arrayRules['event_type_id'] = 'required|integer';
        $arrayRules['incoming_document_id'] = 'nullable|integer';
        $arrayRules['user_ids'] =  "required|array|min:1";
        $arrayRules['structural_unit_id'] = '';

        return $arrayRules;

    }
}
