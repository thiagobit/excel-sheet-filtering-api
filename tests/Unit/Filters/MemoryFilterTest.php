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

        $data = [
            ['Dell R210Intel Xeon X3440', '4GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '32GBDDR3', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $this->dataFilter->applyFilters($data);

        unset($data[1]);

        $this->assertEquals($data, $filteredData);
    }
}
