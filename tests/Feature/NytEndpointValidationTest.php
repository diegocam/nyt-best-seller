<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NytEndpointValidationTest extends TestCase
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
}
