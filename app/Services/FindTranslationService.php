<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;

class FindTranslationService
{
    public function getSample(): Word
    {
        $sample = Word::query()
            ->join('translations', 'words.id', '=', 'translations.word_id')
            ->where('user_id', auth()->id())
            ->select('words.id', 'words.text', 'words.transcription', 'translations.text as translation', 'words.created_at')
            ->inRandomOrder()
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

        $words->add($sample)->shuffle();

        return $words;
    }
}
