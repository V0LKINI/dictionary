<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslateRequest;
use App\Services\DictionaryService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function __construct(private readonly DictionaryService $dictionaryService) {}

    /**
     * Save user data
     *
     * @param Request $request
     */
    public function translate(TranslateRequest $request)
    {
        try {
            $this->dictionaryService->getTranslation(text: $request->text);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
