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

    public function applyFilters($data)
    {
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data);
        }

        return $data;
    }
}
