<?php

namespace App\Http\Requests;

class DictionaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer'],
            'text' => ['required', 'string', 'max:255'],
            'transcription' => ['nullable', 'string', 'max:255'],
            'translation' => ['required', 'string', 'max:255'],
        ];
    }
}
