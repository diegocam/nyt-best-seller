<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function toArray(Request $request): array
    {
        return [
            'type'          => 'books',
            'id'            => $this->createId(),
            'attributes'    => [
                'title'       => Arr::get($this->resource, 'title'),
                'description' => Arr::get($this->resource, 'description'),
                'author'      => Arr::get($this->resource, 'author'),
                'publisher'   => Arr::get($this->resource, 'publisher'),
                'isbns'       => Arr::get($this->resource, 'isbns'),
            ],
            'relationships' => [
                'ranks_history' => [
                    'data' => RankHistoryResource::collection(
                        Arr::get($this->resource, 'ranks_history', [])
                    ),
                ],
            ],
        ];
    }

    private function createId(): string
    {
        return md5(serialize(
            [
                Arr::get($this->resource, 'author'),
                Arr::get($this->resource, 'title'),
            ]
        ));
    }
}
