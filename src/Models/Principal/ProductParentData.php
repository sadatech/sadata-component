<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductParentData extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];
	protected $table = 'product_parent_data';

	protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'name' => $data->name,
	 				'header' => $data->header,
	 				'parent' => $data->parent,
	 				'schema' => $data->schema,
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'name' => $data->fresh()->name,
	 				'header' => $data->fresh()->header,
	 				'parent' => $data->fresh()->parent,
	 				'schema' => $data->fresh()->schema,
	 			],
	 			'new' => [
	 				'name' => $data->name,
	 				'header' => $data->header,
	 				'parent' => $data->parent,
	 				'schema' => $data->schema,
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'name' => $data->name,
	 				'header' => $data->header,
	 				'parent' => $data->parent,
	 				'schema' => $data->schema,
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'parent_id' => 'nullable|integer',
			'header_id' => 'required|integer',
			'schema' => 'nullable|integer'
		];
	}

	public function header()
	{
		return $this->belongsTo(ProductParentHeader::class, 'header_id');
	}

	public function parent()
	{
		return $this->belongsTo(ProductParentData::class, 'parent_id');
	}
}
