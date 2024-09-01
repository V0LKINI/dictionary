<?php

namespace App\Http\Requests;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->id],
            'password' => ['nullable', 'string', 'min:6'],
            'password_confirm' => ['nullable', 'required_with:password', 'string', 'min:6', 'same:password'],
        ];
    }
}
