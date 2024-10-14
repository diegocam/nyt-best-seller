<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BestSellerRequest;
use App\Http\Resources\ResponseResource;
use App\Services\ApiInterface;
use App\Services\NewYorkTimesApi;
use Illuminate\Http\Resources\Json\JsonResource;

class BookController extends Controller
{
    protected ApiInterface $api;

    public function __construct(NewYorkTimesApi $api)
    {
        $this->api = $api;
    }

    public function bestSellers(BestSellerRequest $request): JsonResource
    {
        $input['author'] = $request->input('author');
        $input['title'] = $request->input('title');
        $input['isbns'] = $request->input('isbn');
        $input['offset'] = $request->input('offset', 0);
        $response = $this->api->fetchData($input);

        return new ResponseResource($response);
    }
}
