<?php

namespace App\Http\Requests\Users;

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
            'user_status_id' => 'required|exists:user_statuses,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'structural_unit_id' => 'required|exists:structural_units,id',
			'role' => [
				'required',
				Rule::exists('roles', 'id')->where(function ($query) {
					$query->where('roles.name', '!=', 'admin');
				})
			],
			'birthday_at' => 'nullable|date',
			'surname' => 'required',
			'name' => 'required',
			'middle_name' => 'required',
        ];
    }
}
