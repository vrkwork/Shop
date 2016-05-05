<?php

namespace App\Http\Requests\Item;

use App\Http\Requests\Request;

class ItemAddValidation extends Request
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
            'item_code' => 'required',
            'item_name' => 'required|min:3|max:100'
        ];
    }

    public function messages()
    {
        return [
            'item_code.required' => 'Item Code is required.',
            'item_name.required' => 'Item Name is required.',
            'item_name.min' => 'Item Name should be at least 3 characters.',
            'item_name.max' => 'Item Name cannot exceed 100 characters.'
        ];
    }
}
