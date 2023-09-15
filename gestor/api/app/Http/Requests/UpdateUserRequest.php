<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['string', 'max:70'],
            'username' => ['string', 'max:25', 'unique:users,username,' . $this->input('id')],
            'email' => ['email', 'max:150', 'unique:users,email,' . $this->input('id')],
            'password' => ['string', 'min:6', 'confirmed'],
        ];
    }
}
