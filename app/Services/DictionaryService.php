<?php

namespace App\Services;

use App\Models\User;
use App\Models\Word;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DictionaryService
{
    public function save(array $data): void
    {
        $word = Word::create(['text' => $data['text']]);
    }
}
