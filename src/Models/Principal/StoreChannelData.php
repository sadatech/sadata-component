<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Models\Principal\StoreChannelHeader;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreChannelData extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];
	protected $table = 'store_channel_data';

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
		return $this->belongsTo(StoreChannelHeader::class, 'header_id');
	}

	public function parent()
	{
		return $this->belongsTo(StoreChannelData::class, 'parent_id');
	}

	public function scopeFloorData($query)
	{
		return $query->whereHeaderId(@StoreChannelHeader::orderByDesc('level')->first()->id);
	}
}
