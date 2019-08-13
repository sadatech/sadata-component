<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFocus extends PrincipalModel
{

	use SoftDeletes;

	protected $guarded = [];
	protected $table = "product_focus";

	public static function rule()
	{
		return [
			'product_id' => 'required|integer',
			'area_schema' => 'nullable|string',
			'channel_schema' => 'nullable|string',
			'start_date' => 'required|date',
			'end_date' => 'required|date',
		];
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function area()
	{
		return $this->belongsTo(StoreAreaData::class, 'area_schema', 'schema');
	}

	public function channel()
	{
		return $this->belongsTo(StoreChannelData::class, 'channel_schema', 'schema');
	}

	public static function isActivePF($store_id, $product_id, $date = "now")
	{
		$date = $date == "now" ? date('Y-m-d') : $date;
		$store = Store::findOrFail($store_id);

		$query = self::where('start_date', '<=', $date)
					 ->where('end_date', '>=', $date)
					 ->whereProductId($product_id);

		// CHECK PF BY AREA
		$query->where(function($q) use($store) {
			foreach ($store->area_scope as $key => $area) {
				$q->orWhere('area_schema', $area['schema']);
			}
			$q->orWhere('area_schema', null);
		});

		// CHECK PF BY CHANNEL
		$query->where(function($q) use($store) {
			foreach ($store->channel_scope as $key => $channel) {
				$q->orWhere('channel_schema', $channel['schema']);
			}
			$q->orWhere('channel_schema', null);
		});

		return $query->count();
	}
}
