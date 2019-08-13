<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StoreChannelHeader extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];
	protected $table = 'store_channel_header';

	protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'name' => $data->name,
	 				'level' => $data->level,
	 				'parent' => $data->parent,
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'name' => $data->fresh()->name,
	 				'level' => $data->fresh()->level,
	 				'parent' => $data->fresh()->parent,
	 			],
	 			'new' => [
	 				'name' => $data->name,
	 				'level' => $data->level,
	 				'parent' => $data->parent,
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'name' => $data->name,
	 				'level' => $data->level,
	 				'parent' => $data->parent,
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'parent_id' => 'nullable|integer',
			'level' => 'nullable|integer'
		];
	}

	public function parent()
	{
		return $this->belongsTo(StoreChannelHeader::class, 'parent_id');
	}

	public function getSlugNameAttribute()
	{
		return Str::slug($this->name, '-');
	}

	public function scopeMaxLevelId(){
		return @$this->whereLevel($this->max('level'))->first()->id;
	}
}
