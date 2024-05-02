<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('REQUESTS_BASE_URL');
    }

    public function sendRequest(string $text): string
    {
        $response = Http::withOptions(['verify' => false])->get($this->baseUrl . $text);

        return $response->body();
    }

    public function crawl(string $html): array
    {
        try {
            $data = [];

            $crawler = new Crawler($html);

            $this->getTranscription($crawler, $data);
            $this->getTranslations($crawler, $data);
            $this->getExamples($crawler, $data);

            return $data;
        } catch (InvalidArgumentException $e) {
            return $data;
        }
    }

    public function getTranscription(Crawler $crawler, array &$data): void
    {
        $transcription = $crawler->filter('#us_tr_sound')->children('.transcription')->first()?->text();

        if ($transcription) {
            $data['transcription'] = $transcription;
        }
    }

    public function getTranslations(Crawler $crawler, array &$data): void
    {
        $index = -1;

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

        $phrases = $crawler->filter('#content_in_russian')->children('.phrases')->first()?->text();

        if ($phrases) {
            $data['translations'][] = [
                'speech_part' => 'phrases',
                'words' => explode(" \u{A0} ", $phrases),
            ];
        }

        foreach ($data['translations'] as $index => $part) {
            $data['translations'][$index]['words'] = array_slice($part['words'], 0, 5);
        }
    }

    public function getExamples(Crawler $crawler, array &$data): void
    {
        $crawler->filter('#content_in_russian')->children('.block')->children('.ex_o')->each(function ($node, $i) use (&$data) {
            $data['examples'][$i] = $node->text();
        });

        $crawler->filter('#content_in_russian')->children('.block')->children('.ex_t')->each(function ($node, $i) use (&$data) {
            $data['examples'][$i] .= '- ' . $node->text();
        });

        $data['examples'] = array_slice($data['examples'], 0, 5);
    }
}
