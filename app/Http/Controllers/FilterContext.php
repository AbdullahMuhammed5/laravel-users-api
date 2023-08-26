<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class FilterContext {
    private array $filters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    public function filter($data, Request $request) {
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data, $request);
        }
        return $data;
    }
}
