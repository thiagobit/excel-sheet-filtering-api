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

    /** @test */
    public function harddisk_filter_return_false_if_input_pattern_doesnt_match()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SATA');

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '123', 'AmsterdamAMS-01', '€49.99'],
        ];

        $this->assertFalse($hardDiskTypeFilter->filter($data[0]));
    }
}
