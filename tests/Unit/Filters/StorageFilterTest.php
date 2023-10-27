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

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $this->dataFilter->applyFilters($data);

        unset($data[0]);

        $this->assertEquals($data, $filteredData);
    }

    /** @test */
    public function storage_can_be_filtered_for_GB()
    {
        $storageFilter = new StorageFilter('500GB');

        $this->dataFilter->addFilter($storageFilter);

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '2x120GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $this->dataFilter->applyFilters($data);

        unset($data[0], $data[2]);

        $this->assertEquals($data, $filteredData);
    }
}
