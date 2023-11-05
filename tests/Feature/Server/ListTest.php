<?php

namespace Server;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ListTest extends TestCase
{
    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            ["HP DL180 G92x Intel Xeon E5-2620v3", "64GBDDR4", "2x120GBSSD", "AmsterdamAMS-01", "€199.99"],
            ["Dell R9304x Intel Xeon E7-4850v3", "4GBDDR3", "8x2TBSATA2", "SingaporeSIN-11", "€1044.99"],
            ["Dell R210Intel Xeon X3440", "16GBDDR3", "2x2TBSATA2", "DallasDAL-10", "€49.99"],
        ];

        Cache::set(config('cache.keys.servers'), $this->data);
    }

    /** @test */
    public function servers_can_be_listed()
    {
        $servers = $this->get(route('v1.servers.index'))
            ->assertSuccessful();

        $this->assertEquals($this->data, $servers->json());
    }

    /** @test */
    public function servers_can_be_filtered_by_storage_size()
    {
        $storageSize = '250GB';

        $servers = $this->get(route('v1.servers.index', ['storage' => $storageSize]))
            ->assertSuccessful();

        $this->assertEquals([$this->data[0]], $servers->json());
    }

    /** @test */
    public function storage_size_cannot_be_invalid()
    {
        $storageSize = '10GB';

        $this->get(route('v1.servers.index', ['storage' => $storageSize]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'storage' => 'The selected storage is invalid.'
            ]);
    }

    /** @test */
    public function servers_can_be_filtered_by_memory()
    {
        $memories = ['8', '16', '64'];

        $servers = $this->get(route('v1.servers.index', ['ram' => $memories]))
            ->assertSuccessful();

        unset($this->data[1]);

        $this->assertEquals($this->data, $servers->json());
    }

    /** @test */
    public function memory_cannot_be_invalid()
    {
        $memories = '8';

        $this->get(route('v1.servers.index', ['ram' => $memories]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'ram' => 'The ram field must be an array.'
            ]);

        $memories = ['0', '256'];

        $this->get(route('v1.servers.index', ['ram' => $memories]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'ram' => 'The selected ram is invalid.'
            ]);
    }

    /** @test */
    public function servers_can_be_filtered_by_harddisk_type()
    {
        $hardDiskType = 'SSD';

        $servers = $this->get(route('v1.servers.index', ['harddisk_type' => $hardDiskType]))
            ->assertSuccessful();

        $this->assertEquals([$this->data[0]], $servers->json());
    }

    /** @test */
    public function harddisk_type_cannot_be_invalid()
    {
        $hardDiskType = 'ABC';

        $this->get(route('v1.servers.index', ['harddisk_type' => $hardDiskType]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'harddisk_type' => 'The selected harddisk type is invalid.'
            ]);
    }

    /** @test */
    public function servers_can_be_filtered_by_location()
    {
        $location = 'Amsterdam';

        $servers = $this->get(route('v1.servers.index', ['location' => $location]))
            ->assertSuccessful();

        $this->assertEquals([$this->data[0]], $servers->json());
    }

    /** @test */
    public function location_cannot_be_invalid()
    {
        $location = ['abc'];

        $this->get(route('v1.servers.index', ['location' => $location]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'location' => 'The location field must be a string.'
            ]);

        $location = str_repeat('a', 257);

        $this->get(route('v1.servers.index', ['location' => $location]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'location' => 'The location field must not be greater than 256 characters.'
            ]);
    }
}
