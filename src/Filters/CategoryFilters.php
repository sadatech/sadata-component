<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class CategoryFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('categories.name', 'like', '%'.$value.'%') : null;
    }

    // Order by Cluster
    public function byCluster($value) {
        return (!$this->requestAllData($value)) ? $this->builder->where('categories.cluster_id', $value) : null;
    }

}