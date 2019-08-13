<?php

namespace Sada\SadataComponent\Menus;
use Sada\SadataComponent\Models\ProductParent;

/**
 * 
 */
class MainMenu
{
	
	public static function get()
	{
		// $productParents = [];
		// foreach (ProductParent::get() as $productParent) {
		// 	$productParents[] = ['label' => $productParent->name, 'url' => route('productData.list', $productParent->slug_name)];
		// }


		$data =  [
			[
				'menu' => [
					['label' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'fa fa-home'],
				]
			],
			[
				'section' => 'Master Data',
				'menu' => [
					// ['label' => 'Product(s)', 'url' => 'product', 'icon' => 'fa fa-shapes', 'sub-menu' => array_merge($productParents, [
					// 	['label' => 'Product', 'url' => route('product.list')],
					// 	['label' => 'Product Focus', 'url' => '#'],
					// 	['label' => 'Product Parent', 'url' => route('productParent.list')],
					// ])],
					// ['label' => 'Store(s)', 'url' => 'store', 'icon' => 'fa fa-store', 'sub-menu' => [
					// 	['label' => 'Region', 'url' => route('region.list')],
					// 	['label' => 'Area', 'url' => route('area.list')],
					// 	['label' => 'Channel', 'url' => route('channel.list')],
					// 	['label' => 'Account', 'url' => route('account.list')],
					// 	['label' => 'Timezone', 'url' => '#'],
					// 	['label' => 'Store', 'url' => route('store.list')],
					// ]],
					['label' => 'Companies', 'url' => 'company', 'icon' => 'fa fa-user-tie', 'sub-menu' => [ // alt icon: fa-people-carry 
						['label' => 'Company', 'url' => route('company.list')],
						['label' => 'Payment', 'url' => route('company.payment.list')],
					]],
				],
			]
		];

		return $data;
	}

}
