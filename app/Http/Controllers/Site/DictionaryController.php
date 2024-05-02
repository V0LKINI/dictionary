<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslateRequest;
use App\Services\CrawlerService;
use App\Services\DictionaryService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function __construct(
        private readonly DictionaryService $dictionaryService,
        private readonly CrawlerService $crawlerService,
    ) {}

    /**
     * Save user data
     *
     * @param Request $request
     */
    public function translate(TranslateRequest $request)
    {
        try {
            $html = $this->crawlerService->sendRequest(text: $request->text);
            $data = $this->crawlerService->crawl(html: $html);

            if (empty($data)) {
                //TODO Используем переводчик
            }

            //TODO сохраняем полученные данные

            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
