<?php

namespace Sada\SadataComponent\Filters;

use App\User;
use Illuminate\Support\Carbon;

class MaintenanceRequestFilters extends QueryFilters
{
    public function employee_id($value = null)
    {
        $user = auth()->user();
        $employee_id = $user->isEmployee() ? $user->employee->id : $value;

        return $this->builder->whereEmployeeId($employee_id);
    }

    public function store_id($value = null)
    {
        return $value ? $this->builder->whereStoreId($value) : null;
    }

    public function byAreaScope($value = [])
    {
    	if(empty($value)){
    		return null;
    	}else{
			return $this->builder->whereHas('store', function($q) use ($value){
				foreach ($value as $key => $item) {
					$q->where('stores.area_schema', 'LIKE', '%' . $item . '%');
				}
				return $q;
			});
    	}
    }

    public function byChannelScope($value = [])
    {
    	if(empty($value)){
    		return null;
    	}else{
			return $this->builder->whereHas('store', function($q) use ($value){
				foreach ($value as $key => $item) {
					$q->where('stores.channel_schema', 'LIKE', '%' . $item . '%');
				}
				return $q;
			});
    	}
    }
}