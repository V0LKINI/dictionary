<?php

namespace App\Services;

use App\Models\Translation;
use App\Models\Word;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DictionaryService
{
    public function getPaginator(): LengthAwarePaginator
    {
        $query = Word::query()
            ->join('translations', 'words.id', '=', 'translations.word_id')
            ->where('user_id', auth()->id());

        if ($search = request()->search) {
            $query->where(function ($q) use ($search) {
                $q->where('text', 'like', '%' . $search . '%')
                  ->orWhere('translations.text', 'like', '%' . $search . '%');
            });
        }

        if ($period = request()->period) {
            $query->where('created_at', '>=', now()->sub($period, 1));
        }

        if (request()->sortColumn) {
            $sortColumn = match (request()->sortColumn) {
                'word' => 'text',
                'transcription' => 'transcription',
                'translation' => 'translations.text',
                'date' => 'created_at',
                default => 'created_at',
            };

            $query->orderBy($sortColumn, request()->sortDirection);
        }

        $paginator = $query
            ->select('words.id', 'words.text', 'words.transcription', 'translations.text as translation', 'words.created_at')
            ->paginate(15);

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

    public function edit(array $data): void
    {
        $word = Word::findOrFail($data['id']);

        $translation = Translation::where('word_id', $data['id'])->firstOrFail();

        if (auth()->user()->cannot('edit', $word)) {
            throw new Exception( 'Access denied', 403);
        }

        DB::transaction(function () use ($data, $word, $translation) {
            $word->update([
                'user_id' => auth()->id(),
                'text' => $data['text'],
                'transcription' => $data['transcription']
            ]);

            $translation->update([
                'word_id' => $word->id,
                'text' => $data['translation']
            ]);
        });
    }

    public function delete(int $id): void
    {
        $item = Word::findOrFail($id);

        if (auth()->user()->cannot('delete', $item)) {
            throw new Exception( 'Access denied', 403);
        }

        $item->delete();
    }

    public function getById(int $id): Model
    {
        $item = Word::query()
            ->with(['translations' => function ($q) {
                $q->select('word_id', 'text');
            }])
            ->where('user_id', auth()->id())
            ->select('id', 'text', 'transcription')
            ->findOrFail($id);

        return $item;
    }
}
