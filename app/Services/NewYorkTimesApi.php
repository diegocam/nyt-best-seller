<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewYorkTimesApi implements ApiInterface
{
    public function fetchData(array $params): array
    {
        $apiParams = $this->convertData($params);

        $apiParams['api-key'] = config('services.nyt.key');

        $response = Http::get(config('services.nyt.url'), $apiParams);

        return $response->json();
    }

    public function convertData(array $params): array
    {
        $result = [];

        if (isset($params['author'])) {
            $result['author'] = $params['author'];
        }

        if (!empty($params['isbns'])) {
            $result['isbn'] = implode(';', $params['isbns']);
        }

        if (isset($params['title'])) {
            $result['title'] = $params['title'];
        }

        if (isset($params['offset'])) {
            $result['offset'] = $params['offset'];
        }

        return $result;
    }
}
