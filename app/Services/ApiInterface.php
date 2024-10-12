<?php

namespace App\Services;

interface ApiInterface
{
    public function fetchData(array $params): array;
}
