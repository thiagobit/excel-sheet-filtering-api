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
        return array_filter($data, function ($item) {
            foreach ($this->filters as $filter) {
                if (!$filter->filter($item)) {
                    return false;
                }
            }

            return true;
        });
    }
}
