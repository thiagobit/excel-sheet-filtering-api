<?php

namespace Filters;

use App\Filters\StorageFilter;
use Tests\Unit\FilterTestCase;

class StorageFilterTest extends FilterTestCase
{
    /** @test */
    public function storage_can_be_filtered_for_TB()
    {
        $storageFilter = new StorageFilter('2TB');

        $this->dataFilter->addFilter($storageFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        unset($this->data[0]);

        $this->assertEquals($this->data, $filteredData);
    }

    /** @test */
    public function storage_can_be_filtered_for_GB()
    {
        $storageFilter = new StorageFilter('500GB');

        $this->dataFilter->addFilter($storageFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals(['1' => $this->data[1]], $filteredData);
    }

    /** @test */
    public function storage_filter_return_false_if_input_pattern_doesnt_match()
    {
        $memoryTypeFilter = new StorageFilter('500GB');

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '123', 'AmsterdamAMS-01', '€49.99'],
        ];

        $this->assertFalse($memoryTypeFilter->filter($data[0]));
    }
}
