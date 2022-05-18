<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'person' => [
                'name' => 'required',
                'email' => 'unique:users,email',
                'telephone' => "required",
                'gender' => 'required',
                'document_type' => 'required',
                'document_number' => 'required',
                'birth_date' => 'required',
                'password' => 'required'
            ]

        ];
    }
}
