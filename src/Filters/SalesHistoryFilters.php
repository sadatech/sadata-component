<?php

namespace Sada\SadataComponent\Filters;

use Sada\SadataComponent\Models\Principal\Employee;

class SalesHistoryFilters extends QueryFilters
{

    public function employee_id($value = null)
    {
    	$user = auth()->user();
    	$employee_id = $user->isEmployee() ? $user->employee->id : $value;

    	return $this->builder->whereHas('sales_header', function($q) use ($employee_id) {
    		if ($employee_id) {
				$q->whereEmployeeId($employee_id);
    		}
    	});
    }

    public function store_id($value = null)
    {
    	return $this->builder->whereHas('sales_header', function($q) use ($value) {
    		if ($value) {
				$q->whereStoreId($value);
    		}
    	});
    }

    public function date($value = null)
    {
    	return $this->builder->whereHas('sales_header', function($q) use ($value) {
    		if ($value) {
				$q->where('datetime', 'LIKE', '%'.$value.'%');
    		}
    	});
    }

}