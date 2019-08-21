<?php

namespace Sada\SadataComponent\Filters;

use Illuminate\Http\Request;
use Sada\SadataComponent\Traits\DatatableFilter;

class InvoiceFilters extends QueryFilters
{

    use DatatableFilter;

    /**
     * Ordering data by name
     */
    public function status_not($v) {
        return $this->builder->where('status', '!=', $v);
    }
}