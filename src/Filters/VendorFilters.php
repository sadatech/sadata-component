<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class VendorFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('vendors.name', 'like', '%'.$value.'%') : null;
    }

}