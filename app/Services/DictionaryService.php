<?php

namespace App\Services;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DictionaryService
{
    public function getList(): Collection
    {
        $query = Word::with('translations')->orderByDesc('created_at');

        if ($search = request()->search) {
            $query->where('text', 'like', '%' . $search . '%');
        }

        $data = $query->get();

        return $data;
    }

    public function save(array $data): void
    {
        if (Word::where(['user_id' => auth()->id(), 'text' => $data['text']])->exists()) {
            throw new \Exception('Word already exists', 422);
        }

        DB::transaction(function () use ($data) {
            $word = Word::create(['user_id' => auth()->id(), 'text' => $data['text']]);

            Translation::create(['word_id' => $word->id, 'text' => $data['translation']]);
        });
    }

    public function delete(int $id): void
    {
        $item = Word::findOrFail($id);
        $item->delete();
    }
}
