<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NytEndpointTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

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
    }

    #[DataProvider('nytDataValidationProvider')]
    public function testNytBestSellersEndpointValidation(string $url, int $expectedStatus, ?string $expectedMessage = null): void
    {
        $response = $this->get($url);
        $response->assertStatus($expectedStatus);

        if ($expectedStatus !== 200) {
            $result = $response->json();
            $this->assertEquals(
                $expectedMessage,
                Arr::get($result, 'errors.0.detail.0')
            );
        }
    }

    public static function nytDataValidationProvider(): array
    {
        return [
            'with no params'                                    => [
                '/api/1/nyt/best-sellers',
                200,
            ],

            'with author set to int'                            => [
                '/api/1/nyt/best-sellers?author=12',
                422,
                'The author field must only contain letters.',
            ],

            'with author set to string'                         => [
                '/api/1/nyt/best-sellers?author=Diego',
                200,
            ],

            'with isbn set to integer'                          => [
                '/api/1/nyt/best-sellers?isbn=1',
                422,
                'The isbn field must be an array.',
            ],

            'with isbn set to integer with less than 10 digits' => [
                '/api/1/nyt/best-sellers?isbn[]=12345',
                422,
                'The isbn.0 field must be either 10 or 13 digits.',
            ],

            'with isbn set to integer with 10 digits'           => [
                '/api/1/nyt/best-sellers?isbn[]=1234567890',
                200,
            ],

            'with isbn set to integer with 11 digits'           => [
                '/api/1/nyt/best-sellers?isbn[]=12345678901',
                422,
                'The isbn.0 field must be either 10 or 13 digits.',
            ],

            'with isbn set to integer with 12 digits'           => [
                '/api/1/nyt/best-sellers?isbn[]=123456789012',
                422,
                'The isbn.0 field must be either 10 or 13 digits.',
            ],

            'with isbn set to integer with 13 digits'           => [
                '/api/1/nyt/best-sellers?isbn[]=1234567890123',
                200,
            ],

            'with isbn set to integer with more than 13 digits' => [
                '/api/1/nyt/best-sellers?isbn[]=12345678901234',
                422,
                'The isbn.0 field must be either 10 or 13 digits.',
            ],

            'with isbn set to integer with multiple good isbns' => [
                '/api/1/nyt/best-sellers?isbn[]=1234567890123&isbn[]=1234567890',
                200,
            ],

            'with empty title'                                  => [
                '/api/1/nyt/best-sellers?title=',
                422,
                'The title field must be a string.',
            ],

            'with good title'                                   => [
                '/api/1/nyt/best-sellers?title=foobar',
                200,
            ],

            'with empty offset'                                 => [
                '/api/1/nyt/best-sellers?offset=',
                422,
                'The offset field must be a number.',
            ],

            'with offset set to string'                         => [
                '/api/1/nyt/best-sellers?offset=foobar',
                422,
                'The offset field must be a number.',
            ],

            'with offset not set with multiple of 20'           => [
                '/api/1/nyt/best-sellers?offset=1',
                422,
                'The offset field must be a multiple of 20.',
            ],

            'with good offset'                                  => [
                '/api/1/nyt/best-sellers?offset=20',
                200,
            ],


        ];
    }

    public function testNytBestSellersEndpointResponse(): void
    {
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
}
