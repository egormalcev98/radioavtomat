<?php

namespace App\Http\Requests\IncomingDocuments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SignedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$incomingUserService = app(\App\Services\IncomingDocuments\IncomingUserService::class);
		
        return $incomingUserService->checkSignatureUsers($this->incomingDocument);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'signed' => [
				'required',
				Rule::in(['signed', 'reject']),
			],
        ];
    }
}
