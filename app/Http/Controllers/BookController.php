<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellerRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function bestSellers(BestSellerRequest $request)
    {
        return $request;
    }
}
