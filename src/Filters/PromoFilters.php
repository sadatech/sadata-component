<?php

namespace Sada\SadataComponent\Filters;

use App\User;
use Illuminate\Support\Carbon;

class PromoFilters extends QueryFilters
{
    public function employee_id($value = null)
    {
        $user = auth()->user();
        $employee_id = $user->isEmployee() ? $user->employee->id : $value;

        return $this->builder->whereHas('promo_header', function($q) use ($employee_id) {
            if ($employee_id) {
                $q->whereEmployeeId($employee_id);
            }
        });
    }

    public function store_id($value = null)
    {
        return $value ? $this->builder->whereHas('promo_header', function($q) use ($value) {
            $q->whereStoreId($value);
        }) : null;
    }

    public function start_date($value = null)
    {
        return $value ? $this->builder->whereHas('promo_header', function($q) use ($value){
            return $q->where('start_date', '>=', $value);
        }) : null;
    }

    public function end_date($value = null)
    {
        return $value ? $this->builder->whereHas('promo_header', function($q) use ($value){
            return $q->where('end_date', '<=', $value);
        }) : null;
    }

    public function byAreaScope($value = [])
    {
    	if(empty($value)){
    		return null;
    	}else{
			return $this->builder->whereHas('promo_header.store', function($q) use ($value){
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
			return $this->builder->whereHas('promo_header.store', function($q) use ($value){
				foreach ($value as $key => $item) {
					$q->where('stores.channel_schema', 'LIKE', '%' . $item . '%');
				}
				return $q;
			});
    	}
    }

    public function byProductParentScope($value = [])
    {
    	if(empty($value)){
    		return null;
    	}else{
			return $this->builder->whereHas('product', function($q) use ($value){
				foreach ($value as $key => $item) {
					$q->where('products.schema', 'LIKE', '%' . $item . '%');
				}
				return $q;
			});
    	}
    }
}