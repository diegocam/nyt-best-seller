<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'jsonapi' => ['version' => '1.1'],
            'data'  => BookResource::collection(
                Arr::get($this->resource, 'results')
            )
        ];
    }
}
