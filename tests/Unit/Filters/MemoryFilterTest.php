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
}
