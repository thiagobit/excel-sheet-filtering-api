<?php

namespace App\Filters;

use App\Traits\ConversionTrait;

class StorageFilter implements FilterInterface
{
    use ConversionTrait;

    public function __construct(private readonly string $maxSize) {
    }

    public function filter($data): array
    {
        return array_filter($data, function ($item) {
            // format expected: '2TB'
            $pattern = '/(\d+)(TB|GB|MB|KB|B)([A-Z0-9]+)?/';

            if (!preg_match($pattern, $this->maxSize, $matches)) {
                return $item;
            }

            $quantity = 1;
            $size = (int)$matches[1];
            $unit = $matches[2];

            // convert sizes to GB for comparison
            $maxSizeInGB = $this->convertToGB($quantity, $size, $unit);

            // format expected: '4x480GBSSD'
            $pattern = '/(\d+)x(\d+)(TB|GB|MB|KB|B)([A-Z0-9]+)?/';

            if (!preg_match($pattern, $item[2], $matches)) {
                return $item;
            }

            $quantity = (int)$matches[1];
            $size = (int)$matches[2];
            $unit = $matches[3];

            // convert sizes to GB for comparison
            $storageSize = $this->convertToGB($quantity, $size, $unit);

            return $storageSize <= $maxSizeInGB;
        });
    }
}
