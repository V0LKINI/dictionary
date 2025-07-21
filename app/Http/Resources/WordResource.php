<?php

namespace App\Http\Resources;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Word
 */
class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'transcription' => $this->transcription,
            'translation' => $this->translations->implode('text', ', '),
        ];
    }
}
