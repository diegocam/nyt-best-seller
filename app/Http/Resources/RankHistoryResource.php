<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class RankHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function toArray(Request $request): array
    {
        return [
            'primary_isbn10'   => Arr::get($this->resource, 'primary_isbn10'),
            'primary_isbn13'   => Arr::get($this->resource, 'primary_isbn13'),
            'rank'             => Arr::get($this->resource, 'rank'),
            'list_name'        => Arr::get($this->resource, 'list_name'),
            'display_name'     => Arr::get($this->resource, 'display_name'),
            'published_date'   => Arr::get($this->resource, 'published_date'),
            'bestsellers_date' => Arr::get($this->resource, 'bestsellers_date'),
            'weeks_on_list'    => Arr::get($this->resource, 'weeks_on_list'),
            'rank_last_week'   => Arr::get($this->resource, 'rank_last_week'),
            'asterisk'         => Arr::get($this->resource, 'asterisk'),
            'dagger'           => Arr::get($this->resource, 'dagger'),
        ];
    }
}
