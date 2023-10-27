<?php

namespace Filters;

use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;
use Tests\Unit\FilterTestCase;

class DataFilterTest extends FilterTestCase
{
    /** @test */
    public function filters_can_be_added()
    {
        $storageFilter = new StorageFilter('2TB');
        $memoryFilter = new MemoryFilter(['32', '64']);
        $hardDiskTypeFilter = new HardDiskTypeFilter('SSD');
        $locationFilter = new LocationFilter('Amsterdam');

        $this->dataFilter->addFilter($storageFilter);
        $this->dataFilter->addFilter($memoryFilter);
        $this->dataFilter->addFilter($hardDiskTypeFilter);
        $this->dataFilter->addFilter($locationFilter);

        $this->assertEquals([$storageFilter, $memoryFilter, $hardDiskTypeFilter, $locationFilter], $this->dataFilter->getFilters());
    }

    /** @test */
    public function filters_can_be_applied()
    {
        $storageFilter = new StorageFilter('2TB');

        $this->dataFilter->addFilter($storageFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        unset($this->data[0]);

        $this->assertEquals($this->data, $filteredData);
    }
}
