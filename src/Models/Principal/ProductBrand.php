<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductBrand extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];

	protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'name' => $data->name,
	 				'is_competitor' => $data->is_competitor,
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'name' => $data->fresh()->name,
	 				'is_competitor' => $data->fresh()->is_competitor
	 			],
	 			'new' => [
	 				'name' => $data->name,
	 				'is_competitor' => $data->is_competitor,
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'name' => $data->name,
	 				'is_competitor' => $data->is_competitor,
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'is_competitor' => 'required|integer',
		];
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function getCompetitorAttribute()
	{
		return $this->is_competitor ? 'Yes' : 'No';
	}
}
