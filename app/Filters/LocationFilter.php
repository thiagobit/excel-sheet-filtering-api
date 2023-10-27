<?php

namespace App\Filters;

class LocationFilter implements FilterInterface
{
    public function __construct(private readonly string $location) {
    }

    public function filter($data): array
    {
        return array_filter($data, function ($item) {
            return str_contains($item[3], $this->location);
        });
    }
}
