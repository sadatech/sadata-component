<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];

	protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'product' => $data->product,
	 				'price' => $data->price,
	 				'start_date' => $data->start_date,
	 				'end_date' => $data->end_date,
	 				'area_schema' => $data->area_schema,
	 				'channel_schema' => $data->channel_schema,
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'product' => $data->fresh()->product,
	 				'price' => $data->fresh()->price,
	 				'start_date' => $data->fresh()->start_date,
	 				'end_date' => $data->fresh()->end_date,
	 				'area_schema' => $data->fresh()->area_schema,
	 				'channel_schema' => $data->fresh()->channel_schema,
	 			],
	 			'new' => [
	 				'product' => $data->product,
	 				'price' => $data->price,
	 				'start_date' => $data->start_date,
	 				'end_date' => $data->end_date,
	 				'area_schema' => $data->area_schema,
	 				'channel_schema' => $data->channel_schema,
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'product' => $data->product,
	 				'price' => $data->price,
	 				'start_date' => $data->start_date,
	 				'end_date' => $data->end_date,
	 				'area_schema' => $data->area_schema,
	 				'channel_schema' => $data->channel_schema,
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'product_id' => 'required|integer',
			'price' => 'required|numeric',
			'area_schema' => 'nullable|string',
			'channel_schema' => 'nullable|string'
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
}
