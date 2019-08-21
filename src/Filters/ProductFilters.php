<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class ProductFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('products.name', 'like', '%'.$value.'%') : null;
    }

    // Order by Brand
    public function byBrand($value) {
        return (!$this->requestAllData($value)) ? $this->builder->where('products.brand_id', $value) : null;
    }

}