<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSupervisor extends PrincipalModel
{
	use SoftDeletes;

	protected $guarded = [];
	protected $table = 'employee_supervisor';

	public function area()
	{
		return $this->belongsTo(StoreAreaData::class, 'area_schema', 'schema');
	}

	public function channel()
	{
		return $this->belongsTo(StoreChannelData::class, 'channel_schema', 'schema');
	}

	public function product()
	{
		return $this->belongsTo(ProductParentData::class, 'product_schema', 'schema');
	}
}
