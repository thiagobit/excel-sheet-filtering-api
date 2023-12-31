<?php

namespace App\Filters;

class MemoryFilter implements FilterInterface
{
    public function __construct(private readonly array $memorySizes)
    {
    }

    public function filter($item): bool
    {
        // expected format: '16GB'
        $pattern = '/(\d+)(GB)([A-Z0-9]+)?/';

        if (!preg_match($pattern, $item[1], $matches)) {
            return false;
        }

        $memorySize = $matches[1];

        return in_array($memorySize, $this->memorySizes);
    }
}
