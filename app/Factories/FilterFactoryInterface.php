<?php

namespace App\Factories;

use App\Filters\FilterInterface;

interface FilterFactoryInterface
{
    public static function createFilter(string $filter, mixed $param): FilterInterface;
}
