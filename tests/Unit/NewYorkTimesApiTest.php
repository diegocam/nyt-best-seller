<?php

namespace Tests\Unit;

use App\Services\NewYorkTimesApi;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NewYorkTimesApiTest extends TestCase
{
    protected NewYorkTimesApi $api;

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new NewYorkTimesApi();
    }

    #[DataProvider('nytDataConversionProvider')]
    public function testNytBestSellersApiDataConversion(array $params, array $expectedOutput): void
    {
        $apiParams = $this->api->convertData($params);
        $this->assertSame($expectedOutput, $apiParams);
    }

    public static function nytDataConversionProvider(): array
    {
        return [
            'with no data' => [
                [],
                [],
            ],

            'author with no value' => [
                [
                    'author'
                ],
                [],
            ],

            'author with value' => [
                [
                    'author' => 'some'
                ],
                [
                    'author' => 'some'
                ],
            ],

            'isbns with no value' => [
                [
                    'isbns'
                ],
                [],
            ],

            'isbns with string value' => [
                [
                    'isbns' => ''
                ],
                [],
            ],

            'isbns with empty array' => [
                [
                    'isbns' => []
                ],
                [],
            ],

            'isbns with one element' => [
                [
                    'isbns' => [
                        '1234567890'
                    ]
                ],
                [
                    'isbn' => '1234567890'
                ],
            ],

            'isbns with two elements' => [
                [
                    'isbns' => [
                        '1234567890',
                        '1234567890123',
                    ]
                ],
                [
                    'isbn' => '1234567890;1234567890123',
                ],
            ],

            'title with no value' => [
                [
                    'title'
                ],
                [],
            ],

            'title with value' => [
                [
                    'title' => 'some'
                ],
                [
                    'title' => 'some'
                ],
            ],

            'offset with no value' => [
                [
                    'offset'
                ],
                [],
            ],

            'offset with value' => [
                [
                    'offset' => '0'
                ],
                [
                    'offset' => '0'
                ],
            ],
        ];
    }
}
