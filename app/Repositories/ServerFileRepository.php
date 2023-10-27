<?php

namespace App\Repositories;

use App\Filters\DataFilter;
use App\Filters\HardDiskTypeFilter;
use App\Filters\LocationFilter;
use App\Filters\MemoryFilter;
use App\Filters\StorageFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ServerFileRepository implements RepositoryInterface
{
    public function __construct(protected DataFilter $dataFilter)
    {
    }

    private function loadData(): array
    {
        $spreadsheet = IOFactory::load(storage_path('servers/LeaseWeb_servers_filters_assignment.xlsx'));
        $servers = $spreadsheet->getActiveSheet()->toArray();

        // remove headers
        unset($servers[0]);

        return $servers;
    }

    public function all(array $filters = []): array
    {
        $servers = $this->loadData();

        if (empty($servers)) {
            return [];
        }

        if (isset($filters['storage'])) {
            $storageFilter = new StorageFilter($filters['storage']);
            $this->dataFilter->addFilter($storageFilter);
        }

        if (isset($filters['ram'])) {
            $memoryFilter = new MemoryFilter($filters['ram']);
            $this->dataFilter->addFilter($memoryFilter);
        }

        if (isset($filters['harddisk_type'])) {
            $hardDiskTypeFilter = new HardDiskTypeFilter($filters['harddisk_type']);
            $this->dataFilter->addFilter($hardDiskTypeFilter);
        }

        if (isset($filters['location'])) {
            $LocationFilter = new LocationFilter($filters['location']);
            $this->dataFilter->addFilter($LocationFilter);
        }

        return $this->dataFilter->applyFilters($servers);
    }
}
