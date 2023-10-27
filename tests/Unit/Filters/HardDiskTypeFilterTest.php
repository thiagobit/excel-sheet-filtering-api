<?php

namespace Filters;

use App\Filters\HardDiskTypeFilter;
use Tests\Unit\FilterTestCase;

class HardDiskTypeFilterTest extends FilterTestCase
{
    /** @test */
    public function harddisk_can_be_filtered_for_SATA()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SATA');

        $this->dataFilter->addFilter($hardDiskTypeFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals([$this->data[0]], $filteredData);
    }

    /** @test */
    public function harddisk_can_be_filtered_for_SSD()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SSD');

        $this->dataFilter->addFilter($hardDiskTypeFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals(['1' => $this->data[1]], $filteredData);
    }

    /** @test */
    public function harddisk_can_be_filtered_for_SAS()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SAS');

        $this->dataFilter->addFilter($hardDiskTypeFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals(['2' => $this->data[2]], $filteredData);
    }
}
