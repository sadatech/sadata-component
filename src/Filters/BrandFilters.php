<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class BrandFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('brands.name', 'like', '%'.$value.'%') : null;
    }

    // Order by Category
    public function byCategory($value) {
        return (!$this->requestAllData($value)) ? $this->builder->where('brands.category_id', $value) : null;
    }

}