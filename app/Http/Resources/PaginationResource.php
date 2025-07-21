<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @mixin LengthAwarePaginator
 */
class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->total(),
            'links' => $this->linkCollection(),
            'currentPage' => $this->currentPage(),
            'lastPage' => $this->lastPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }
}
