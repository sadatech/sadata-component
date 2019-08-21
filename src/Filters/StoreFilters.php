<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;

class StoreFilters extends QueryFilters
{

    /**
     * Ordering data by name
     */
    public function q($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('stores.name', 'like', '%'.$value.'%')->orWhere('stores.alias_name', 'like', '%'.$value.'%')->orWhere('stores.code', 'like', '%'.$value.'%') : null;
    }

    public function filters($values)
    {
        foreach ($values as $method => $value) {
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }

    public function byName($value = '')
    {
        return $this->builder->where('name', 'LIKE', '%'.$value.'%');
    }

    public function byArea($value = '')
    {
        return $this->builder->where('area_schema', 'LIKE', '%'.$value.'%');
    }

    public function byChannel($value = '')
    {
        return $this->builder->where('channel_schema', 'LIKE', '%'.$value.'%');
    }

    public function by_searching($value = '')
    {
        return $this->builder->where('name', 'LIKE', '%'.$value.'%')
                             ->orWhere('code', 'LIKE', '%'.$value.'%')
                             ->orWhere('alias_name', 'LIKE', '%'.$value.'%')
                             ->orWhere('address', 'LIKE', '%'.$value.'%');
    }

}