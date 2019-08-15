<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Models\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class Permission extends MainModel
{
	protected $guarded = [];
	protected $table = 'auth_permissions';

	public static function listOfRoutes()
	{
		$exclude = ['datatable', 'data'];

		$routes = [];
		foreach (Route::getRoutes()->getRoutes() as $key => $route) {
			$routeName = $route->getName();

			if (!empty($routeName) && $key > 52) {
				$include = true;
				$rSection = explode('.', $routeName);

				foreach ($rSection as $value) {
					if (in_array($value, $exclude)) {
						$include = false;
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
