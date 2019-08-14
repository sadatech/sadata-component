<?php

namespace Sada\SadataComponent\Menus;

use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\ProductParentHeader;
use Sada\SadataComponent\Models\Principal\StoreAreaHeader;
use Sada\SadataComponent\Models\Principal\StoreChannelHeader;

/**
 * 
 */
class PrincipalTopBarMenu
{
	
	public static function get()
	{
		$data =  [
			['label' => 'Export(s) Status', 'url' => route('utilities.export'), 'icon' => 'flaticon-clipboard'],
			['label' => 'Activity Log(s)', 'url' => route('utilities.logs'), 'icon' => 'flaticon-time'],
		];
		return self::filter($data);
	}

	public static function filter($data)
	{
		$user = auth()->user();

		if ($user->role_id != Roles::SUPER_ADMIN) {
			foreach ($data as $index => $menu) {
				$routeName = url_to_route_name($menu['url']);
				if (!($user->hasPermissionTo($routeName) || $user->role->hasPermissionTo($routeName))) {
					unset($data[$index]);
				}
			}
		}

		return $data;
	}

}
