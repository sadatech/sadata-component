<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class ClusterFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = "all") {
        return (!$this->requestAllData($value)) ? $this->builder->where('clusters.name', 'like', '%'.$value.'%') : null;
    }

}