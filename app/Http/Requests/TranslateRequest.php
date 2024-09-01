<?php

namespace App\Http\Requests;

class TranslateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['required'],
        ];
    }
}
