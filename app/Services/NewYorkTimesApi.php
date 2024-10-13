<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewYorkTimesApi implements ApiInterface
{
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

        $response = Http::get(config('services.nyt.url'), $apiParams);

        return $response->json();
    }
}
