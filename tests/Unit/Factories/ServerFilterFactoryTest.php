<?php

namespace Tests\Unit\Factories;

use App\Factories\ServerFilterFactory;
use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;
use PHPUnit\Framework\TestCase;

class ServerFilterFactoryTest extends TestCase
{
    /** @test */
    public function storage_filter_can_be_fabricated()
    {
        $serverFilter = ServerFilterFactory::createFilter('storage', '72TB');

        $this->assertInstanceOf(StorageFilter::class, $serverFilter);
    }

    /** @test */
    public function memory_filter_can_be_fabricated()
    {
        $serverFilter = ServerFilterFactory::createFilter('ram', ['64']);

        $this->assertInstanceOf(MemoryFilter::class, $serverFilter);
    }

    /** @test */
    public function harddisk_type_filter_can_be_fabricated()
    {
        $serverFilter = ServerFilterFactory::createFilter('harddisk_type', 'SSD');

        $this->assertInstanceOf(HardDiskTypeFilter::class, $serverFilter);
    }

    /** @test */
    public function location_filter_can_be_fabricated()
    {
        $serverFilter = ServerFilterFactory::createFilter('location', 'Amsterdam');

        $this->assertInstanceOf(LocationFilter::class, $serverFilter);
    }
}
