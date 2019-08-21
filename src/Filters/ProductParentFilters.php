<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class ProductParentFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = all) {
        return (!$this->requestAllData($value)) ? $this->builder->where('product_parents.name', 'like', '%'.$value.'%') : null;
    }

}