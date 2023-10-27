<?php

namespace Tests\Unit\Repositories;

use App\Filters\DataFilter;
use App\Repositories\ServerFileRepository;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ServerFileRepositoryTest extends TestCase
{
    /** @test */
    public function can_return_all_data()
    {
        $data = [
            ["HP DL180 G92x Intel Xeon E5-2620v3", "64GBDDR4", "2x120GBSSD", "AmsterdamAMS-01", "€199.99"],
            ["Dell R9304x Intel Xeon E7-4850v3", "4GBDDR3", "8x2TBSATA2", "SingaporeSIN-11", "€1044.99"],
            ["Dell R210Intel Xeon X3440", "16GBDDR3", "2x2TBSATA2", "DallasDAL-10", "€49.99"],
        ];

        Cache::set(config('cache.keys.servers'), $data);

        $serverFileRepository = new ServerFileRepository(new DataFilter());

        $servers = $serverFileRepository->all();

        $this->assertEquals($data, $servers);
    }
}
