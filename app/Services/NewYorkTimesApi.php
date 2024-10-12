<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewYorkTimesApi implements ApiInterface
{
    const URL = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json';

    public function fetchData(array $params): array
    {
        $apiParams['api-key'] = config('services.nyt.key');

        if (isset($params['author'])) {
            $apiParams['author'] = $params['author'];
        }

        if (isset($params['isbns'])) {
            $apiParams['isbn'] = implode(';', $params['isbns']);
        }

        if (isset($params['title'])) {
            $apiParams['title'] = $params['title'];
        }

        if (isset($params['offset'])) {
            $apiParams['offset'] = $params['offset'];
        }

        $response = Http::get(self::URL, $apiParams);

        return $response->json();
    }
}
