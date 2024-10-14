<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NytEndpointResponseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::preventStrayRequests();
    }

    public function testNytBestSellersEndpointResponseToJsonApi(): void
    {
        Http::fake([
            'https://api.nytimes.com/*' => Http::response(
                json_decode(
                    file_get_contents(
                        storage_path('samples/nytBestSellerResponse.json')
                    ),
                    true
                )
            ),
        ]);
        $response = $this->get('/api/1/nyt/best-sellers');
        $response->assertJson([
            'jsonapi' => [
                'version' => '1.1',
            ],
            'data'    => [
                [
                    'type'          => 'books',
                    'id'            => 'ac6e70b49143a664b471aed484a0c2b7',
                    'attributes'    => [
                        'title'       => '"I GIVE YOU MY BODY ..."',
                        'description' => 'The author of the Outlander novels gives tips on writing sex scenes, drawing on examples from the books.',
                        'author'      => 'Diana Gabaldon',
                        'publisher'   => 'Dell',
                        'isbns'       => [
                            [
                                'isbn10' => '0399178570',
                                'isbn13' => '9780399178573',
                            ],
                        ],
                    ],
                    'relationships' => [
                        'ranks_history' => [
                            'data' => [
                                [
                                    'primary_isbn10'   => '0399178570',
                                    'primary_isbn13'   => '9780399178573',
                                    'rank'             => 8,
                                    'list_name'        => 'Advice How-To and Miscellaneous',
                                    'display_name'     => 'Advice, How-To & Miscellaneous',
                                    'published_date'   => '2016-09-04',
                                    'bestsellers_date' => '2016-08-20',
                                    'weeks_on_list'    => 1,
                                    'rank_last_week'   => 0,
                                    'asterisk'         => 0,
                                    'dagger'           => 0,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type'          => 'books',
                    'id'            => 'a6f9b920ae122c723eab3c43f6f5752f',
                    'attributes'    => [
                        'title'       => '"MOST BLESSED OF THE PATRIARCHS"',
                        'description' => 'A character study that attempts to make sense of Jefferson’s contradictions.',
                        'author'      => 'Annette Gordon-Reed and Peter S Onuf',
                        'publisher'   => 'Liveright',
                        'isbns'       => [
                            [
                                'isbn10' => '0871404427',
                                'isbn13' => '9780871404428',
                            ],
                        ],
                    ],
                    'relationships' => [
                        'ranks_history' => [
                            'data' => [
                                [
                                    'primary_isbn10'   => '0871404427',
                                    'primary_isbn13'   => '9780871404428',
                                    'rank'             => 16,
                                    'list_name'        => 'Hardcover Nonfiction',
                                    'display_name'     => 'Hardcover Nonfiction',
                                    'published_date'   => '2016-05-01',
                                    'bestsellers_date' => '2016-04-16',
                                    'weeks_on_list'    => 1,
                                    'rank_last_week'   => 0,
                                    'asterisk'         => 1,
                                    'dagger'           => 0,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testNytBestSellersEndpointUnauthorizedResponse(): void
    {
        Http::fake([
            'https://api.nytimes.com/*' => Http::response([], 401),
        ]);
        $response = $this->get('/api/1/nyt/best-sellers');

        $response->assertJson([
            "errors" => [
                [
                    "status" => 401,
                    "title"  => "Unauthorized",
                    "detail" => "The request was unauthorized. Check that you have the correct credentials.",
                ],
            ],
        ]);
    }

    public function testNytBestSellersEndpointBadRequestResponse(): void
    {
        Http::fake([
            'https://api.nytimes.com/*' => Http::response([], 400),
        ]);
        $response = $this->get('/api/1/nyt/best-sellers');

        $response->assertJson([
            "errors" => [
                [
                    "status" => 400,
                    "title"  => "Bad Request",
                    "detail" => "There was an issue processing this request. Check that the endpoint and parameters given are correct.",
                ],
            ],
        ]);
    }
}
