<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function toArray(Request $request): array
    {
        return [
            'jsonapi' => ['version' => '1.1'],
            'data'    => BookResource::collection(
                Arr::get($this->resource, 'results')
            ),
        ];
    }
}
