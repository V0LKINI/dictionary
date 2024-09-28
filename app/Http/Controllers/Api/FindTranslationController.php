<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WordsListResource;
use App\Services\FindTranslationService;
use Illuminate\Http\JsonResponse;

class FindTranslationController extends Controller
{
    public function __construct(private readonly FindTranslationService $findTranslationService) {}

    /**
     * Get exercise data
     *
     * @return JsonResponse|true[]
     */
    public function getData()
    {
        try {
            $sample = $this->findTranslationService->getSample();
            $words = $this->findTranslationService->getWords(sample: $sample);

            return $this->success([
                'sample' => WordsListResource::make($sample),
                'words' => WordsListResource::collection($words),
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
