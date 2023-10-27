<?php

namespace App\Repositories;

use App\Factories\ServerFilterFactory;
use App\Filters\DataFilter;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ServerFileRepository implements RepositoryInterface
{
    public function __construct(protected DataFilter $dataFilter)
    {
    }

    private function loadData(): array
    {
        return Cache::remember('servers', now()->addMinutes(30), function () {
            $spreadsheet = IOFactory::load(storage_path('app/servers/LeaseWeb_servers_filters_assignment.xlsx'));
            $servers = $spreadsheet->getActiveSheet()->toArray();

            // remove headers
            unset($servers[0]);

            return $servers;
        });
    }

    public function all(array $filters = []): array
    {
        $servers = $this->loadData();

        if (empty($servers)) {
            return [];
        }

        foreach ($filters as $filter => $param) {
            $serverFilter = ServerFilterFactory::createFilter($filter, $param);

            $this->dataFilter->addFilter($serverFilter);
        }

        return $this->dataFilter->applyFilters($servers);
    }
}
