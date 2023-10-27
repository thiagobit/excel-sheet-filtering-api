<?php

namespace Filters;

use App\Filters\HardDiskTypeFilter;
use PHPUnit\Framework\TestCase;

class HardDiskTypeFilterTest extends TestCase
{
    /** @test */
    public function filter_works_for_SATA()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SATA');

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $hardDiskTypeFilter->filter($data);

        unset($data[1]);

        $this->assertEquals($data, $filteredData);
    }

    /** @test */
    public function filter_works_for_SSD()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SSD');

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSATA2', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $hardDiskTypeFilter->filter($data);

        unset($data[0], $data[2]);

        $this->assertEquals($data, $filteredData);
    }

    /** @test */
    public function filter_works_for_SAS()
    {
        $hardDiskTypeFilter = new HardDiskTypeFilter('SAS');

        $data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '64GBDDR4', '4x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR43', '2x1TBSAS', 'SingaporeSIN-11', '€154.99'],
        ];

        $filteredData = $hardDiskTypeFilter->filter($data);

        unset($data[0], $data[1]);

        $this->assertEquals($data, $filteredData);
    }
}
