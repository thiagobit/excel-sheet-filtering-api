<?php

namespace Tests\Feature;

use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServerIndexTest extends TestCase
{
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
        $filteredServers = $storageFilter->filter($servers->json());

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
        $filteredServers = $memoryFilter->filter($servers->json());

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
        $filteredServers = $hardDiskTypeFilter->filter($servers->json());

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

        $location = new LocationFilter($location);
        $filteredServers = $location->filter($servers->json());

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
