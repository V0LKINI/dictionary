<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WordsListResource;
use App\Services\ExercisesService;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExercisesController extends Controller
{
    public function __construct(
        private readonly ExercisesService $exercisesService,
        private readonly ProfileService $profileService,
    ) {}

    /**
     * Get exercise data
     *
     * @return JsonResponse|true[]
     */
    public function getData()
    {
        try {
            $sample = $this->exercisesService->getSample();
            $words = $this->exercisesService->getWords(sample: $sample);

            return $this->success([
                'sample' => WordsListResource::make($sample),
                'words' => WordsListResource::collection($words),
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Save experience for word and update word's repeated datetime
     *
     * @return JsonResponse|true[]
     */
    public function saveAnswer(Request $request)
    {
        try {
            $this->exercisesService->updateRepeatedDatetime(wordId: $request->wordId);

            $this->profileService->incrementExperience();

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
