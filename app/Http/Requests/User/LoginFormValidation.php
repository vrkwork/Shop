<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class LoginFormValidation extends Request
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
            'username' => 'required|min:5',
            'password' => 'required|min:4|max:26'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'You have to insert email.',
            'username.min' => 'Please, insert at least 5 characters for email.',
            'password.min' => 'Please, insert at lease 5 characters for password.'
        ];
    }
}
