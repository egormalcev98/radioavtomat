<?php

namespace App\Http\Requests\OutgoingDocuments;

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
            'letter_form_id' => 'required|exists:letter_forms,id',
            'title' => 'required|max:255',
            'outgoing_doc_status_id' => 'required|exists:outgoing_doc_statuses,id',
            'document_type_id' => 'required|exists:document_types,id',
            'number_pages' => 'required|numeric',
            'counterparty' => 'required|max:255',
            'number' => 'required|unique:outgoing_documents,number|numeric',
            'incoming_letter_number' => 'required|numeric',
            'date_letter_at' => 'required|date',
            'from_user_id' => 'required|exists:users,id',
            'note' => 'nullable|max:400',
            'new_scan_files.*' => 'nullable|file|mimes:pdf,doc,docx,xlsx,bmp,jpeg',
        ];
    }
}
