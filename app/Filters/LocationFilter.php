<?php

namespace App\Filters;

class LocationFilter implements FilterInterface
{
    public function __construct(private readonly string $location) {
    }

    public function filter($item): bool
    {
        return str_contains($item[3], $this->location);
    }
}
