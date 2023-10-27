<?php

namespace Server;

use App\Filters\DataFilter;
use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;
use Tests\TestCase;

class ListTest extends TestCase
{
    protected DataFilter $dataFilter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataFilter = new DataFilter();
    }

    /** @test */
    public function servers_can_be_listed()
    {
        $servers = $this->get(route('v1.servers.index'))
            ->assertSuccessful();

        $this->assertNotEmpty($servers);
    }

    /** @test */
    public function servers_can_be_filtered_by_storage_size()
    {
        $storageSize = '250GB';

        $servers = $this->get(route('v1.servers.index', ['storage' => $storageSize]))
            ->assertSuccessful();

        $storageFilter = new StorageFilter($storageSize);

        $this->dataFilter->addFilter($storageFilter);

        $filteredServers = $this->dataFilter->applyFilters($servers->json());

        $this->assertEquals($servers->json(), $filteredServers);
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

        $memoryFilter = new MemoryFilter($memories);

        $this->dataFilter->addFilter($memoryFilter);

        $filteredServers = $this->dataFilter->applyFilters($servers->json());

        $this->assertEquals($servers->json(), $filteredServers);
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

        $hardDiskTypeFilter = new HardDiskTypeFilter($hardDiskType);

        $this->dataFilter->addFilter($hardDiskTypeFilter);

        $filteredServers = $this->dataFilter->applyFilters($servers->json());

        $this->assertEquals($servers->json(), $filteredServers);
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

        $locationFilter = new LocationFilter($location);

        $this->dataFilter->addFilter($locationFilter);

        $filteredServers = $this->dataFilter->applyFilters($servers->json());

        $this->assertEquals($servers->json(), $filteredServers);
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
