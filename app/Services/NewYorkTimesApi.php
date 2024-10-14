<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Http;

class NewYorkTimesApi implements ApiInterface
{
    public function fetchData(array $params): array
    {
        $apiParams = $this->convertData($params);

        $apiParams['api-key'] = config('services.nyt.key');

        $response = Http::get(config('services.nyt.url'), $apiParams);

        if ($response->status() === 401) {
            throw new UnauthorizedException();
        }

        if ($response->status() === 400) {
            throw new BadRequestException();
        }

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
