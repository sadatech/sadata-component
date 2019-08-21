<?php

namespace Sada\SadataComponent\Filters;

use Sada\SadataComponent\Models\Principal\Employee;

class OosHistoryFilters extends QueryFilters
{

    public function employee_id($value = null)
    {
    	$user = auth()->user();
    	$employee_id = $user->isEmployee() ? $user->employee->id : $value;

    	return $this->builder->whereHas('oos_header', function($q) use ($employee_id) {
    		if ($employee_id) {
				$q->whereEmployeeId($employee_id);
    		}
    	});
    }

    public function store_id($value)
    {
    	return $this->builder->whereHas('oos_header', function($q) use ($value) {
			$q->whereStoreId($value);
    	});
    }

    public function date($value)
    {
    	return $this->builder->whereHas('oos_header', function($q) use ($value) {
			$q->where('datetime', 'LIKE', $value.'%');
    	});
    }

}