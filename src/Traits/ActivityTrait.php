<?php

namespace Sada\SadataComponent\Traits;

use Sada\SadataComponent\Models\Principal\Activity;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

trait ActivityTrait
{
	public function logCreatedActivity($logModel, $request, $user = 1)
   	{
    	$activity = activity()
        	 ->causedBy(($user == 1) ? auth()->user() : $user)
           	->performedOn($logModel)
           	->withProperties($request)
           	->tap(function(Activity $activity) use ($logModel) {
    		   		$activity->request_from = (\Agent::isDesktop()) ? 'WEB' : 'API';
    		   		$activity->ip_address = \Request::ip();
    		   	})
           	->log('CREATE');
 
       	return true;
   	}

   	public function logUpdatedActivity($logModel, $request, $user = 1)
   	{
    	$activity = activity()
        	->causedBy(($user == 1) ? auth()->user() : $user)
           	->performedOn($logModel)
           	->withProperties($request)
           	->tap(function(Activity $activity) use ($logModel) {
    		   		$activity->request_from = (\Agent::isDesktop()) ? 'WEB' : 'API';
    		   		$activity->ip_address = \Request::ip();
    		   	})
           	->log('UPDATE');
 
       	return true;
   	}

   	public function logDeletedActivity($logModel, $request, $user = 1)
   	{
       	$activity = activity()
           	->causedBy(($user == 1) ? auth()->user() : $user)
           	->performedOn($logModel)
           	->withProperties($request)
           	->tap(function(Activity $activity) use ($logModel) {
    		   		$activity->request_from = (\Agent::isDesktop()) ? 'WEB' : 'API';
    		   		$activity->ip_address = \Request::ip();
    		   	})
           	->log('DELETE');
 
       	return true;
   	}

   	public function logLoginDetails($logModel)
   	{
       	$activity = activity()
           	->causedBy($logModel)
           	->performedOn($logModel)
           	->tap(function(Activity $activity) use ($logModel) {
    		   		$activity->request_from = (\Agent::isDesktop()) ? 'WEB' : 'API';
    		   		$activity->ip_address = \Request::ip();
    		   	})
           	->log('LOGIN');
 
       	return true;
   	}
}