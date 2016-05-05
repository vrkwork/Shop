<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\Request;

class PurchaseAddValidation extends Request
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
            'item_code' => 'required|exists:item,item_code',
            'item_name' => 'required|exists:item,item_name',
            'qty' => 'required|integer',
            'rate' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'item_code.required' => 'Item Code is required.',
            'item_code.exists' => 'Item Code does not exist.',
            'item_name.required' => 'Item Name is required.',
            'item_name.exists' => 'Item Name does not exist.',
            'qty.required' => 'Quantity is required.',
            'qty.integer' => 'Quantity must be number/integer.',
            'rate.required' => 'Rate is required.',
            'rate.integer' => 'Rate must be number.',
        ];
    }
}
