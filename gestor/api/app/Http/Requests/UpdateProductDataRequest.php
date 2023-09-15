<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductDataRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'string', 'max:30', 'unique:product_data,type,' . $this->id . ',id,product_id,' . $this->product_id],
            'cost' => ['required', 'decimal:0,2'],
            'price' => ['required', 'decimal:0,2'],
            'profit' => ['required', 'decimal:0,3'],
            'amount' => ['required', 'numeric'],
            'code' => ['string', 'nullable'],
        ];
    }
}
