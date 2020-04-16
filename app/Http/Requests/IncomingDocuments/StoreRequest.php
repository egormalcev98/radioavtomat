<?php

namespace App\Http\Requests\IncomingDocuments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'required',
            'incoming_doc_status_id' => 'required|exists:incoming_doc_statuses,id',
            'document_type_id' => 'required|exists:document_types,id',
            'counterparty' => 'required',
            'number' => 'required|integer|unique:incoming_documents,number',
            'date_letter_at' => 'nullable|date',
            'from' => 'required',
            'date_delivery_at' => 'nullable|date',
            'register' => [
				Rule::requiredIf(function () {
					return $this->register_automatic === null;
				}),
				'nullable',
				'integer',
			],
            'number_pages' => 'required|integer',
            'recipient_id' => 'nullable|exists:users,id',
            'new_scan_files.*' => 'nullable|file|mimes:pdf,doc,docx,xlsx,bmp,jpeg',
        ];
    }
}
