<?php

namespace App\Filters;

class DataFilter
{
    private array $filters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function applyFilters($data): array
    {
        $filters = $this->getFilters();

        if (empty($filters)) {
            return $data;
        }
        
        return array_filter($data, function ($item) use ($filters) {
            foreach ($filters as $filter) {
                if (!$filter->filter($item)) {
                    return false;
                }
            }

            return true;
        });
    }
}
