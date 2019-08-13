<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\Main\JobTrace;
use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Models\Principal\Activity;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends PrincipalModel
{
	use SoftDeletes, ActivityTrait;

	// APPEND HIDDEN
	const APPENDS = ['parent_scope'];
	const HIDDENS = ['parent'];

	protected $guarded = [];

	protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'name' => $data->name,
	 				'scope' =>$data->getParentScopeAttribute(),
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'name' => $data->fresh()->name,
	 				'scope' =>$data->fresh()->getParentScopeAttribute(),
	 			],
	 			'new' => [
	 				'name' => $data->name,
	 				'scope' =>$data->getParentScopeAttribute(),
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'name' => $data->name,
	 				'scope' =>$data->getParentScopeAttribute(),
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'parent_data_id' => 'required|integer',
			'schema' => 'required|string',
			'product_brand_id' => 'required|integer',
		];
	}

	public function parent()
	{
		return $this->belongsTo(ProductParentData::class, 'parent_data_id');
	}

	public function brand()
	{
		return $this->belongsTo(ProductBrand::class, 'product_brand_id');
	}

	public static function getParentHeader()
	{
		return ProductParentHeader::orderByDesc('level')->first();
	}

	public function getCompetitorAttribute()
	{
		return $this->is_competitor ? 'Yes' : 'No'; 
	}

	public function prices()
	{
		return $this->hasMany(ProductPrice::class);
	}

	public function getParentScopeAttribute(){
    	$result = [];
		$parent = $this->parent;
		while (($parent->parent_id ?? null) != null) {
			$result[] = [
				"field" => str_replace('-', '_', $parent->header->slug_name)."_name",
				"schema" => $parent->schema,
				"value" => $parent->name
			];
			$parent = $parent->parent;
		}

		if($parent){
			$result[] = [
				"field" => str_replace('-', '_', $parent->header->slug_name)."_name",
				"schema" => $parent->schema,
				"value" => $parent->name
			];
		}

		return $result;
    }

    public function getPrices($date = null)
    {
    	if($date == null){
    		return 0;
    	}

    	return $this->prices->where('start_date', '<=', $date)
    					    ->where('end_date', '>=', $date)
    					    ->first()->price;
    }
}
