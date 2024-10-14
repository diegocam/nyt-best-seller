<?php

declare(strict_types=1);

namespace App\Services;

interface ApiInterface
{
    public function fetchData(array $params): array;
}
