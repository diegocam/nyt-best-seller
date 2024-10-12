<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellerRequest;
use App\Services\ApiInterface;
use App\Services\NewYorkTimesApi;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected ApiInterface $api;

    public function __construct(NewYorkTimesApi $api)
    {
        $this->api = $api;
    }

    public function bestSellers(BestSellerRequest $request)
    {
        $params['author'] = $request->input('author');
        $params['title'] = $request->input('title');
        $params['isbns'] = $request->input('isbn');
        $params['offset'] = $request->input('offset', 0);

        $response = $this->api->fetchData($params);

        return $response;
    }
}
