<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class UserFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    }

    // Order by Region
    public function company_id($value = null) {
        return  $value === null ? null : $this->builder->where('company_id', $value);
    }

}