<?php

namespace Filters;

use App\Filters\MemoryFilter;
use Tests\Unit\FilterTestCase;

class MemoryFilterTest extends FilterTestCase
{
    /** @test */
    public function memory_can_be_filtered()
    {
        $memoryFilter = new MemoryFilter(['4', '32']);

        $this->dataFilter->addFilter($memoryFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals(['1' => $this->data[1]], $filteredData);
    }

    /** @test */
    public function memory_filter_return_false_if_input_pattern_doesnt_match()
    {
        $memoryTypeFilter = new MemoryFilter(['4']);

        $data = [
            ['Dell R210Intel Xeon X3440', '123', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
        ];

        $this->assertFalse($memoryTypeFilter->filter($data[0]));
    }
}
