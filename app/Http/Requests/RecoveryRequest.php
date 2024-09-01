<?php

namespace App\Http\Requests;

class RecoveryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'credentials' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function messages()
    {
        return [
            'credentials.exists' => 'User not found',
        ];
    }
}
