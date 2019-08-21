<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class AreaDataFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function byParentArea($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('schema', 'like', '%'.$value.'%') : null;
    }

}