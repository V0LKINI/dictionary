<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
