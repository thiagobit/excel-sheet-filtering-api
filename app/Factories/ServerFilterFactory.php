<?php

namespace App\Factories;

use App\Filters\FilterInterface;
use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;

class ServerFilterFactory implements FilterFactoryInterface
{
    public static function createFilter(string $filter, mixed $param): FilterInterface
    {
        return match ($filter) {
            'storage' => new StorageFilter($param),
            'ram' => new MemoryFilter($param),
            'harddisk_type' => new HardDiskTypeFilter($param),
            'location' => new LocationFilter($param),
        };
    }
}
