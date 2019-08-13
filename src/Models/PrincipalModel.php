<?php

namespace Sada\SadataComponent\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PrincipalModel extends BaseModel
{
	protected $connection = 'principal';

	// protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'deleted_at'];

	// public function tapActivity(Activity $activity, string $eventName)
 //    {
 //    	$agent = new Agent();
 //    	if(!$agent->isDesktop()){
 //    		$activity->request_from = 'API';
 //    	}else{
 //    		$activity->request_from = 'WEB';
 //    	}

 //    	$activity->ip_address = \Request::ip();
        
 //    }
}
