<?php

namespace App\Services;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DictionaryService
{
    public function getPaginator(): LengthAwarePaginator
    {
        $query = Word::with('translations')->where('user_id', auth()->id());

        if ($search = request()->search) {
            $query->where('text', 'like', '%' . $search . '%');
        }

        if ($period = request()->period) {
            $query->where('created_at', '>=', now()->sub($period, 1));
        }

        $paginator = $query->orderByDesc('created_at')->paginate(15);

        return $paginator;
    }

    public function save(array $data): void
    {
        if (Word::where(['user_id' => auth()->id(), 'text' => $data['text']])->exists()) {
            throw new \Exception('Word already exists', 422);
        }

        DB::transaction(function () use ($data) {
            $word = Word::create([
                'user_id' => auth()->id(),
                'text' => $data['text'],
                'transcription' => $data['transcription']
            ]);

            Translation::create([
                'word_id' => $word->id,
                'text' => $data['translation']
            ]);
        });
    }

    public function delete(int $id): void
    {
        $item = Word::findOrFail($id);
        $item->delete();
    }
}
