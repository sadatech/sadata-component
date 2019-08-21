<?php

namespace Sada\SadataComponent\Filters;

use App\User;
use Illuminate\Support\Carbon;

class OosFilters extends QueryFilters
{
    public function byEmployee($value = '')
    {
        return $this->builder->whereHas('oos_header.employee', function($q) use ($value){
        	return $q->where('id', $value);
        });
    }

    public function byMonth($value = 'all')
    {
    	if($value == 'all'){
    		return null;
    	}

    	$monthYear = explode('-', $value);
        return $this->builder->whereHas('oos_header', function($q) use ($monthYear){
        	return $q->whereMonth('datetime', $monthYear[1])->whereYear('datetime', $monthYear[0]);
        });
    }

    public function byDate($value = 'all')
    {
    	if($value == 'all'){
    		return null;
    	}

    	$date = Carbon::parse($value);
        return $this->builder->whereHas('oos_header', function($q) use ($date){
        	return $q->whereDate('datetime', $date);
        });
    }

    public function byAreaScope($value = [])
    {
    	if(empty($value)){
    		return null;
    	}else{
			return $this->builder->whereHas('oos_header.store', function($q) use ($value){
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
			return $this->builder->whereHas('oos_header.store', function($q) use ($value){
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