<?php

namespace App\Services;

use App\Models\Word;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ExercisesService
{
    public function getSample(): Word
    {
        $sample = Word::query()
            ->join('translations', 'words.id', '=', 'translations.word_id')
            ->where('user_id', auth()->id())
            ->select('words.id', 'words.text', 'words.transcription', 'translations.text as translation', 'words.created_at')
            ->orderBy('repeated_at')
            ->first();

        return $sample;
    }

    public function getWords(Word $sample): Collection
    {
        $words = Word::query()
            ->join('translations', 'words.id', '=', 'translations.word_id')
            ->where('user_id', auth()->id())
            ->where('words.id', '!=', $sample->id)
            ->select('words.id', 'words.text', 'words.transcription', 'translations.text as translation', 'words.created_at')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $words->add($sample);

        return $words->shuffle();
    }

    public function updateRepeatedDatetime(int $wordId): void
    {
        $word = Word::findOrFail($wordId);

        if (auth()->user()->cannot('edit', $word)) {
            throw new Exception( 'Access denied', 403);
        }

        $word->repeated_at = now();
        $word->save();
    }
}
