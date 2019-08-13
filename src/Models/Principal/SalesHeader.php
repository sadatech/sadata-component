<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesHeader extends PrincipalModel
{

	use SoftDeletes;

	const TYPE_SALES_IN = 'SALES IN';
	const TYPE_SALES_OUT = 'SALES OUT';

	protected $guarded = [];
	protected $table = 'sales_header';

	public static function rule()
	{
		return [
			'store_id' => 'required|integer',
			'employee_id' => 'required|integer',
			'datetime' => 'required|date',
			'type' => 'required|string'
		];
	}

	public function store()
	{
		return $this->belongsTo(Store::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function sales_details()
	{
		return $this->hasMany(SalesDetail::class);
	}

	public function getSalesItemsAttribute()
	{
		return $this->sales_details;
	}

	public function syncPF()
	{
		foreach ($this->sales_details as $salesDetail) {
			$salesDetail->syncPF(true);
		}

		return $this;
	}
}
