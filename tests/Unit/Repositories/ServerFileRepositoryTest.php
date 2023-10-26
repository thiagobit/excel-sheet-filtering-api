<?php

namespace Tests\Unit\Repositories;

use App\Filters\DataFilter;
use App\Repositories\ServerFileRepository;
use Tests\TestCase;

class ServerFileRepositoryTest extends TestCase
{
    /** @test */
    public function can_return_all_data()
    {
        $serverFileRepository = new ServerFileRepository(new DataFilter());

        $data = $serverFileRepository->all();

        $this->assertNotEmpty($data);
    }
}
