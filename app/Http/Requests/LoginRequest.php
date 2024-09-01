<?php

namespace App\Http\Requests;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'credentials' => ['required'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
