<?php

namespace Filters;

use App\Filters\DataFilter;
use App\Filters\StorageFilter;
use PHPUnit\Framework\TestCase;

class DataFilterTest extends TestCase
{
    /** @test */
    public function filters_can_be_added()
    {
        $dataFilter = new DataFilter();
        $storageFilter = new StorageFilter('2TB');

        $dataFilter->addFilter($storageFilter);

        $this->assertEquals([$storageFilter], $dataFilter->getFilters());
    }
    /** @test */
    public function filters_can_be_applied()
    {
        $dataFilter = new DataFilter();
        $storageFilter = new StorageFilter('2TB');

        $dataFilter->addFilter($storageFilter);

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $dataFilter->applyFilters($data);

        unset($data[0]);

        $this->assertEquals($data, $filteredData);
    }
}
