<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class AccountFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('accounts.name', 'like', '%'.$value.'%') : null;
    }

    // Order by Region
    public function byRegion($value) {
        return (!$this->requestAllData($value)) ? $this->builder->where('accounts.region_id', $value) : null;
    }

}