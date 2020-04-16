<?php

namespace App\Http\Requests\IncomingDocuments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserRequest extends FormRequest
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
		$admin = \App\User::admin();
		
        return [
			'users.*.employee_task_id' => 'required|exists:App\Models\References\EmployeeTask,id',
			'users.*.sign_up_date' => 'nullable|date',
			'users.*.sign_up_time' => 'nullable|date_format:H:i',
			'users' => 'required',
			'select' => 'required',
			'select.*' => [
				'required',
				Rule::exists('App\User', 'id')->where(function ($query) use($admin) {
					$query->where('id', '!=', $admin->id);
				}),
			],
        ];
    }
	
	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'select.*.required' => __('incoming_documents.users.validation.select'),
			'select.*.exists' => __('incoming_documents.users.validation.error'),
			'users.*.sign_up_date.date' => __('incoming_documents.users.validation.error'),
			'users.*.sign_up_time.date_format' => __('incoming_documents.users.validation.error'),
			'users.*.employee_task_id.required' => __('incoming_documents.users.validation.error'),
			'users.*.employee_task_id.exists' => __('incoming_documents.users.validation.error'),
			'users.required' => __('incoming_documents.users.validation.error'),
			'select.required' => __('incoming_documents.users.validation.select'),
		];
	}
}
