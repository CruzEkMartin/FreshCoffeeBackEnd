<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            //
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'El Email es obligatorio.',
            'email.email' => 'El Email no es válido.',
            'email.exists' => 'El Usuario no existe.',
            'password' => 'El Password es obligatorio.'
        ];
    }
}
