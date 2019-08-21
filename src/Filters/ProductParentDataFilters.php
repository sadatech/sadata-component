<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class ProductParentDataFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function byParentProduct($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('schema', 'like', '%'.$value.'%') : null;
    }

}