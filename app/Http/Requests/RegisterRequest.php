<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'credentials' => ['required'],
            'password' => ['required', 'string', 'min:6'],
            'password_confirm' => ['required', 'string', 'min:6', 'same:password'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
