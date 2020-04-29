<?php

namespace App\Http\Requests\Notes;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'category_note_id' => 'required|exists:category_notes,id',
            'status_note_id' => 'required|exists:status_notes,id',
            'pages' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'created_at' => 'required|date',
            'text' => 'nullable',
            'new_scan_files.*' => 'nullable|file|mimes:pdf,doc,docx,xlsx,bmp,jpeg',
        ];
    }
}
