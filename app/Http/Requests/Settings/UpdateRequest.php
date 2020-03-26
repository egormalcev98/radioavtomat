<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'admin.email' => [
				'required',
				'email',
				Rule::unique('users', 'email')
					->ignore($admin->id),
			],
			'admin.password' => 'nullable|min:5',
			
			'logo_img' => 'nullable|image|max:500|dimensions:width=145,height=145',
			'background_img' => 'nullable|image|max:3000|dimensions:width=1920,height=1080',
        ];
    }
}
