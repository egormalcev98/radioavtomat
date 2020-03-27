<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
		
		$arrayRules['password'] = "nullable|min:5";
		
		$arrayRules['email'] = [
			'required',
			'email',
			Rule::unique('users', 'email')
				->ignore($this->user),
		];
		
		return $arrayRules;
    }
}
