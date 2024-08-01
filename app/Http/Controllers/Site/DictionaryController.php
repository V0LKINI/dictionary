<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\DictionaryRequest;
use App\Http\Requests\TranslateRequest;
use App\Services\CrawlerService;
use App\Services\DictionaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function __construct(
        private readonly DictionaryService $dictionaryService,
        private readonly CrawlerService $crawlerService,
    ) {}


    /**
     * Translate word
     *
     * @return void
     */
    public function translate()
    {

    }

    /**
     * Crawl word's info
     *
     * @param Request $request
     */
    public function crawl(TranslateRequest $request)
    {
        try {
            $html = $this->crawlerService->sendRequest(text: $request->text);
            $data = $this->crawlerService->crawl(html: $html);

            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Save translation
     *
     * @param DictionaryRequest $request
     * @return JsonResponse|true[]
     */
    public function save(DictionaryRequest $request)
    {
        try {
            $data = $request->validated();

            $this->dictionaryService->save(data: $data);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
