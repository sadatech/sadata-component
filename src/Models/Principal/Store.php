<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Store extends PrincipalModel
{

	const TZ_WIB = 'Asia/Jakarta'; 
	const TZ_WITA = 'Asia/Makassar';
	const TZ_WIT = 'Asia/Papua';

	// APPEND HIDDEN
	const APPENDS = ['is_office_explain', 'area_scope', 'channel_scope'];
	const HIDDENS = ['area_schema', 'channel_schema', 'is_office', 'area', 'channel'];

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];
	protected $table = 'stores';

	protected static function boot()
	{
	    parent::boot();	 

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'code' => $data->code,
	 				'name' => $data->name,
	 				'alias_name' => $data->alias_name,
	 				'address' => $data->address,
	 				'latitude' => $data->latitude,
	 				'longitude' => $data->longitude,
	 				'timezone' => $data->timezone,
	 				'is_office' => $data->is_office,
	 				'area_scope' => $data->getAreaScopeAttribute(),
	 				'channel_scope' =>$data->getChannelScopeAttribute(),
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'code' => $data->fresh()->code,
	 				'name' => $data->fresh()->name,
	 				'alias_name' => $data->fresh()->alias_name,
	 				'address' => $data->fresh()->address,
	 				'latitude' => $data->fresh()->latitude,
	 				'longitude' => $data->fresh()->longitude,
	 				'timezone' => $data->fresh()->timezone,
	 				'is_office' => $data->fresh()->is_office,
	 				'area_scope' => $data->fresh()->getAreaScopeAttribute(),
	 				'channel_scope' =>$data->fresh()->getChannelScopeAttribute(),
	 			],
	 			'new' => [
	 				'code' => $data->code,
	 				'name' => $data->name,
	 				'alias_name' => $data->alias_name,
	 				'address' => $data->address,
	 				'latitude' => $data->latitude,
	 				'longitude' => $data->longitude,
	 				'timezone' => $data->timezone,
	 				'is_office' => $data->is_office,
	 				'area_scope' => $data->getAreaScopeAttribute(),
	 				'channel_scope' =>$data->getChannelScopeAttribute(),
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'code' => $data->code,
	 				'name' => $data->name,
	 				'alias_name' => $data->alias_name,
	 				'address' => $data->address,
	 				'latitude' => $data->latitude,
	 				'longitude' => $data->longitude,
	 				'timezone' => $data->timezone,
	 				'is_office' => $data->is_office,
	 				'area_scope' => $data->getAreaScopeAttribute(),
	 				'channel_scope' =>$data->getChannelScopeAttribute(),
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'code' => 'nullable|string',
			'area_data_id' => 'nullable|integer',
			'channel_data_id' => 'nullable|integer',
			'area_schema' => 'nullable|string',
			'channel_schema' => 'nullable|string',
			'alias_name' => 'nullable|string',
			'address' => 'nullable|string',
			'latitude' => 'nullable|string',
			'longitude' => 'nullable|string',
			'timezone' => 'required|string',
			'is_office' => 'nullable|integer',
		];
	}

	public static function getTimezoneList()
	{
		return [
			'Asia/Jakarta' => 'WIB',
			'Asia/Makassar' => 'WITA',
			'Asia/Papua' => 'WIT',
		];
	}

	public static function getTimezoneListAlt()
	{
		return [
			[
				'id' => 'Asia/Jakarta',
				'name' => 'WIB'
			],
			[
				'id' => 'Asia/Makassar',
				'name' => 'WITA'
			],
			[
				'id' => 'Asia/Papua',
				'name' => 'WIT'
			]
		];
	}	

	public function area()
	{
		return $this->belongsTo(StoreAreaData::class, 'area_data_id');
	}

	public function channel()
	{
		return $this->belongsTo(StoreChannelData::class, 'channel_data_id');
	}

	public function employeeStores()
    {
      return $this->hasMany(EmployeeStore::class, 'store_id');
    }	
	
	public static function getAreaHeader()
	{
		return StoreAreaHeader::orderByDesc('level')->first();
	}

	public static function getChannelHeader()
	{
		return StoreChannelHeader::orderByDesc('level')->first();
	}

	public function getEmployeesAttribute()
	{
		$query = $this->join('employee_store AS es', 'stores.id', '=', 'es.store_id')
					->join('employees AS e', 'es.employee_id', '=', 'e.id')
					->where('es.deleted_at', null)
					->where('stores.id', $this->id)
					->select('stores.id as store_id', 'e.id', 'e.name', 'es.date_in', 'es.date_out', 'es.id as employee_store_id');
		
		if (auth()->user()->isTL()) {
			$query->whereIn('es.employee_id', auth()->user()->employee->teams->pluck('id')->toArray());
		}

		return $query->get();
	}

	public function getParentsName($id = null)
	{
		$result = [];
		$area = $this->area;
		while ($area->parent_id != null) {
			$result[str_replace('-', '_', $area->header->slug_name)."_name"] = $area->name;
			$area = $area->parent;
		}

		$result[str_replace('-', '_', $area->header->slug_name)."_name"] = $parent->name;

		return $result;
	}

	public function getAreaScopeAttribute(){
    	$result = [];
		$area = $this->area;
		while (($area->parent_id ?? null) != null) {
			$result[] = [
				"field" => str_replace('-', '_', $area->header->slug_name)."_name",
				"schema" => $area->schema,
				"value" => $area->name
			];
			$area = $area->parent;
		}

		if($area){
			$result[] = [
				"field" => str_replace('-', '_', $area->header->slug_name)."_name",
				"schema" => $area->schema,
				"value" => $area->name
			];
		}

		return $result;
    }

    public function getChannelScopeAttribute(){
    	$result = [];
		$channel = $this->channel;
		while (($channel->parent_id ?? null) != null) {
			$result[] = [
				"field" => str_replace('-', '_', $channel->header->slug_name)."_name",
				"schema" => $channel->schema,
				"value" => $channel->name
			];
			$channel = $channel->parent;
		}

		if($channel){
			$result[] = [
				"field" => str_replace('-', '_', $channel->header->slug_name)."_name",
				"schema" => $channel->schema,
				"value" => $channel->name
			];
		}

		return $result;
    }

    public function getIsOfficeExplainAttribute(){
		$explain = "STORE";
		if($this->is_office == 1) $explain = "OFFICE";
		return $explain;
	}

	public function scopeNotLinked($query)
	{
		// $employee_id = [auth()->user()->employee->id];

		// if (auth()->user()->role_id == Roles::TEAM_LEADER) {
  //           $employee_id = array_merge($employee_id, auth()->user()->teams->pluck('id')->toArray());
  //       }

		$storeIds = EmployeeStore::where('employee_id', auth()->user()->employee->id)->pluck('store_id');		
		return $query->whereNotIn('id', $storeIds);
	}
}
