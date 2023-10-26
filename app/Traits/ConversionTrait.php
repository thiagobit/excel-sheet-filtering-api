<?php

namespace App\Traits;

trait ConversionTrait
{
    public function convertToGB(int $quantity, int $size, string $unit): float|int
    {
        // if it is already in GB
        $sizeInGB = $quantity * $size;

        switch ($unit) {
            case 'TB':
                $sizeInGB *= 1024;
                break;
            case 'MB':
                $sizeInGB /= 1024;
                break;
        }

        return $sizeInGB;
    }
}
