<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DictionaryService
{
    public function getTranslation(string $text): array
    {
        return [];
    }
}
