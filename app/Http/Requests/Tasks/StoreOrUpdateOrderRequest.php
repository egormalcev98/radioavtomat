<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdateOrderRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'text' => 'nullable|max:400',
            "user_ids" => "required_without_all:select_all,structural_unit_id|array|min:1",
            "user_ids.*"  => "required|integer|distinct|min:1",
            "remember_time"  => 'required|integer',
            'new_scan_file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,bmp,jpeg',
            'structural_unit_id' => 'nullable|integer',
        ];
    }
}
