<?php

namespace Tests\Unit;

use App\Filters\DataFilter;
use PHPUnit\Framework\TestCase;

class FilterTestCase extends TestCase
{
    protected DataFilter $dataFilter;
    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataFilter = new DataFilter();

        $this->data = [
            ['Dell R210Intel Xeon X3440', '16GBDDR3', '4x2TBSATA2', 'AmsterdamAMS-01', '€49.99'],
            ['RH2288v32x Intel Xeon E5-2620v4', '32GBDDR4', '1x500GBSSD', 'Washington D.C.WDC-01', '€161.99'],
            ['HP DL120G91x Intel E5-1650v3', '64GBDDR4', '2x1TBSAS', 'SingaporeSIN-11', '€154.99'],
        ];
    }
}
