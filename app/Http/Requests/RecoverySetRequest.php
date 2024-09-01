<?php

namespace App\Http\Requests;

class RecoverySetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'credentials' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'password_confirm' => ['required', 'string', 'min:6', 'same:password'],
        ];
    }
}
