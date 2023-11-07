<?php

namespace App\Filters;

use App\Traits\ConversionTrait;

class StorageFilter implements FilterInterface
{
    use ConversionTrait;

    // max size in GB
    private readonly int|float $maxSize;

    public function __construct(string $maxSize)
    {
        $this->setMaxSize($maxSize);
    }

    public function getMaxSize(): int|float
    {
        return $this->maxSize;
    }

    protected function setMaxSize(string $maxSize): void
    {
        // expected format: '2TB'
        $pattern = '/(\d+)(TB|GB|MB|KB|B)([A-Z0-9]+)?/';

        if (!preg_match($pattern, $maxSize, $matches)) {
            $this->maxSize = 0;

            return;
        }

        $quantity = 1;
        $size = (int)$matches[1];
        $unit = $matches[2];

        // convert to GB for comparison
        $this->maxSize = $this->convertToGB($quantity, $size, $unit);
    }

    public function filter($item): bool
    {
        // expected format: '4x480GBSSD'
        $pattern = '/(\d+)x(\d+)(TB|GB|MB|KB|B)([A-Z0-9]+)?/';

        if (!preg_match($pattern, $item[2], $matches)) {
            return false;
        }

        $quantity = (int)$matches[1];
        $size = (int)$matches[2];
        $unit = $matches[3];

        // convert to GB for comparison
        $storageSize = $this->convertToGB($quantity, $size, $unit);

        return $storageSize <= $this->maxSize;
    }
}
