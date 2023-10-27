<?php

namespace App\Filters;

class HardDiskTypeFilter implements FilterInterface
{
    public function __construct(private readonly string $type) {
    }

    public function filter($data): array
    {
        return array_filter($data, function ($item) {
            // format expected: '2x500GBSATA2'
            $pattern = '/(\d+)x(\d+)(TB|GB|MB|KB|B)([A-Z0-9]+)?/';

            if (!preg_match($pattern, $item[2], $matches)) {
                return $item;
            }

            $type = $matches[4];

            return str_contains($type, $this->type);
        });
    }
}
