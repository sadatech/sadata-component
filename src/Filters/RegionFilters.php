<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class RegionFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = "all") {
        return (!$this->requestAllData($value)) ? $this->builder->where('regions.name', 'like', '%'.$value.'%') : null;
    }

}