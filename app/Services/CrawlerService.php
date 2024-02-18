<?php

namespace App\Services;

use DOMDocument;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Mockery\Exception;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService
{
    private string $baseUrl;

    public function __construct() {
        $this->baseUrl = env('REQUESTS_BASE_URL');
    }

    public function sendRequest(string $text): string
    {
        $response = Http::withOptions(['verify' => false])->get($this->baseUrl . $text);

        return $response->body();
    }

    public function crawl(string $html): array
    {
        $crawler = new Crawler($html);

        $data = [];

        try {
            $index = -1;

            $data['transcription'] = $crawler->filter('#us_tr_sound')->children('.transcription')->first()->text();

            $crawler->filter('#content_in_russian')->children()->each(function ($node, $i) use (&$data, &$index) {
                if (str_contains($node->attr('class'), 'pos_item')) {
                    $data['translations'][]['speech_part'] = str_replace([' ↓'], '', $node->text());
                    $index++;
                }

                if (str_contains($node->attr('class'), 'tr')) {
                    if (count($node->children('span')) > 0) {
                        $data['translations'][$index]['words'] = $node->children('span')->each(function ($node, $i) use (&$data) {
                            return $node->text();
                        });

                        if (str_starts_with(end($data['translations'][$index]['words']), 'ещё ')) {
                            array_pop($data['translations'][$index]['words']);
                        }
                    } else {
                        $data['translations'][$index]['words'][]  = str_replace('- ', '', $node->text());
                    }
                }

                return $data;
            });

            return $data;
        } catch (InvalidArgumentException $e) {
            return $data;
        }
    }
}
