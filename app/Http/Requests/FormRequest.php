<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as ParentFormRequest;

abstract class FormRequest extends ParentFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
