<?php

namespace App\Http\Requests;

class LocaleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale' => ['required', 'in:ru,en'],
        ];
    }
}
