<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\Request;

class SupplierUpdateValidation extends Request
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
            'name' => 'required',
            'address' => 'required|max:200',
            'phone' => 'numeric',
            'mobile' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'address.required' => 'Address is required.',
            'address.max' => 'Address cannot exceed 100 characters.',
            'phone.numeric' => 'Phone must be numeric.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.numeric' => 'Mobile number must be numeric.'
        ];
    }
}
