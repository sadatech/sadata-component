<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;

class ChannelDataFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function byParentChannel($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('schema', 'like', '%'.$value.'%') : null;
    }

}