<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Models\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Permission extends MainModel
{
	protected $guarded = [];
	protected $table = 'auth_permissions';

	public static function listOfRoutes()
	{
		$routes = [];
		foreach (Route::getRoutes()->getRoutes() as $key => $route) {
			$routeName = $route->getName();

			if (!empty($routeName)) {
				$rSection = explode('.', $routeName);

				foreach (config('sadata')['excludedRoutes'] as $excludedRoute) {
					$include = !Str::is($excludedRoute, $routeName);
					if (!$include) {
						break;
					}
				}

				if($include) {
					$title = $rSection[0];
					unset($rSection[0]);
					$permission = str_replace('_', ' ', implode(' ', $rSection));

					$routes[$routeName] = ucwords("$title - $permission");
				}
			}
		}
		return $routes;
	}
}
