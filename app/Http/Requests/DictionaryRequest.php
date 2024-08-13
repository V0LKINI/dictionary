<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DictionaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['required'],
            'translation' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
