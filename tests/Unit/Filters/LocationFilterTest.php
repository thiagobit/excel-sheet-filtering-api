<?php

namespace Filters;

use App\Filters\LocationFilter;
use Tests\Unit\FilterTestCase;

class LocationFilterTest extends FilterTestCase
{
    /** @test */
    public function location_can_be_filtered()
    {
        $locationFilter = new LocationFilter('Amsterdam');

        $this->dataFilter->addFilter($locationFilter);

        $filteredData = $this->dataFilter->applyFilters($this->data);

        $this->assertEquals([$this->data[0]], $filteredData);
    }
}
