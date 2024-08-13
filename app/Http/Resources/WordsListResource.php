<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordsListResource extends JsonResource
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
            'translations' => $this->translations->implode('text', ', '),
            'created_at' => Carbon::parse($this->created_at)->format('d F Y, H:i:m')
        ];
    }
}
