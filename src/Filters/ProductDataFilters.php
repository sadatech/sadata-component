<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class ProductDataFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = all) {
        return (!$this->requestAllData($value)) ? $this->builder->where('product_datas.name', 'like', '%'.$value.'%') : null;
    }

}