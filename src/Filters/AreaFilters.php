<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class AreaFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('areas.name', 'like', '%'.$value.'%') : null;
    }

    // Order by Region
    public function byRegion($value) {
        return (!$this->requestAllData($value)) ? $this->builder->where('areas.region_id', $value) : null;
    }

}