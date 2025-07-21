<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DictionaryRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\WordResource;
use App\Http\Resources\WordsListResource;
use App\Services\DictionaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function __construct(private readonly DictionaryService $dictionaryService,) {}

    /**
     * Get words list
     *
     * @return JsonResponse|true[]
     */
    public function list(Request $request)
    {
        try {
            $paginator = $this->dictionaryService->getPaginator();

            return $this->success([
                'items' => WordsListResource::collection($paginator->items()),
                'pagination' => PaginationResource::make($paginator)
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get word data by id
     *
     * @return JsonResponse|true[]
     */
    public function show(Request $request, int $id)
    {
        try {
            $item = $this->dictionaryService->getById(id: $id);

            return $this->success(WordResource::make($item));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Save word
     *
     * @return JsonResponse|true[]
     */
    public function save(DictionaryRequest $request)
    {
        try {
            $data = $request->validated();

            if (isset($data['id'])) {
                $this->dictionaryService->edit(data: $data);
            } else {
                $this->dictionaryService->save(data: $data);
            }

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete words
     *
     * @return JsonResponse|true[]
     */
    public function delete(int $id)
    {
        try {
            $this->dictionaryService->delete(id: $id);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
