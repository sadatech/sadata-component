<?php

namespace App\Components\Menus;

use App\Models\Main\Roles;
use App\Models\Principal\ProductParentHeader;
use App\Models\Principal\StoreAreaHeader;
use App\Models\Principal\StoreChannelHeader;

/**
 * 
 */
class PrincipalMenu
{
	
	public static function get()
	{
		$storeAreaHeaders = [];
		foreach (StoreAreaHeader::orderBy('level')->get() as $storeAreaHeader) {
			$storeAreaHeaders[] = ['label' => $storeAreaHeader->name, 'url' => route('store.area_data.list', $storeAreaHeader->slug_name)];
		}

		$storeChannelHeaders = [];
		foreach (StoreChannelHeader::orderBy('level')->get() as $storeChannelHeader) {
			$storeChannelHeaders[] = ['label' => $storeChannelHeader->name, 'url' => route('store.channel_data.list', $storeChannelHeader->slug_name)];
		}

		$storeParent = array_merge($storeChannelHeaders, $storeAreaHeaders);

		$productParents = [];
		foreach (ProductParentHeader::orderBy('level')->get() as $productParentHeader) {
			$productParents[] = ['label' => $productParentHeader->name, 'url' => route('product.parent_data.list', $productParentHeader->slug_name)];
		}



		$data =  [
			[
				'menu' => [
					['label' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'fa fa-chart-line'],
				]
			],
			[
				'section' => 'Master Data',
				'menu' => [
					['label' => 'Product(s)', 'url' => 'product', 'icon' => 'fa fa-shapes', 'sub-menu' => array_merge($productParents, [
						['label' => 'Product', 'url' => route('product.list')],
						['label' => 'Product Brand', 'url' => route('product.brand.list')],
						['label' => 'Product Parent', 'url' => route('product.parent_header.list')],
						['label' => 'Product Focus', 'url' => route('product.focus.list')],
					])],
					['label' => 'Store(s)', 'url' => 'store', 'icon' => 'fa fa-store', 'sub-menu' => array_merge($storeParent, [ // alt icon:  
						['label' => 'Store', 'url' => route('store.list')],
						['label' => 'Area Scope', 'url' => route('store.area_header.list')],
						['label' => 'Channel Scope', 'url' => route('store.channel_header.list')],
					])],
					['label' => 'Employee(s)', 'url' => 'employee', 'icon' => 'fa fa-user-tie', 'sub-menu' => [ // alt icon:  
						['label' => 'Employee', 'url' => route('employee.list')],
						['label' => 'Assignment', 'url' => route('employee.list', 'assign')],
						['label' => 'Resigned', 'url' => route('employee.list', 'resign')],
						['label' => 'Employee Store', 'url' => route('employee_store.list')],
					]],
				],
			],
			[
				'section' => 'Report',
				'menu' => [
					['label' => 'Attendance', 'url' => route('attendance.list'), 'icon' => 'fa fa-calendar-alt'],
					['label' => 'Sales', 'url' => 'sales', 'icon' => 'fa fa-shopping-cart', 'sub-menu' => [ // alt icon:  
						['label' => 'Sell In', 'url' => route('sales.list', 1)],
						['label' => 'Sell Out', 'url' => route('sales.list', 2)],
					]],
					['label' => 'OOS', 'url' => route('oos.list'), 'icon' => 'fa fa-truck-loading'],
					['label' => 'SOS', 'url' => route('sos.list'), 'icon' => 'fa fa-table'],
					['label' => 'Promo Tracking', 'url' => route('promo.list'), 'icon' => 'fa fa-tags'],
				],
			],
			[
				'section' => 'Settings',
				'menu' => [
					['label' => 'Permission', 'url' => route('setting.permission.list'), 'icon' => 'fa fa-user-lock'],
				],
			]
		];

		if (auth()->user()->role_id == Roles::SUPER_ADMIN) {
			array_push($data, [
				'section' => 'SUPER ADMIN MENU',
				'menu' => [
					['label' => 'Logout From ' . auth()->user()->company->name, 'url' => route('impersonate_company.logout'), 'icon' => 'fa fa-sign-out-alt'],
				]
			]);
		}

		return self::filter($data);
	}

	public static function filter($data)
	{
		$user = auth()->user();

		if ($user->role_id != Roles::SUPER_ADMIN) {
			foreach ($data as $index => $list) {
				foreach ($list['menu'] as $menuIndex => $menu) {

					if (isset($menu['sub-menu'])) {
						foreach ($menu['sub-menu'] as $subMenuIndex => $subMenu) {
							$routeName = url_to_route_name($subMenu['url']);
							if (!($user->hasPermissionTo($routeName) || $user->role->hasPermissionTo($routeName))) {
								unset($data[$index]['menu'][$menuIndex]['sub-menu'][$subMenuIndex]);
							}
						}

						if (count($data[$index]['menu'][$menuIndex]['sub-menu']) == 0) {
							unset($data[$index]['menu'][$menuIndex]);
						}
					}else{
						$routeName = url_to_route_name($menu['url']);
						if (!($user->hasPermissionTo($routeName) || $user->role->hasPermissionTo($routeName))) {
							unset($data[$index]['menu'][$menuIndex]);
						}
					}
				}

				if (count($data[$index]['menu']) == 0) {
					unset($data[$index]);
				}

			}
		}

		return $data;
	}

}
