<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OosHeader extends PrincipalModel
{

	use SoftDeletes;

	protected $guarded = [];
	protected $table = 'oos_header';

	public static function rule()
	{
		return [
			'store_id' => 'required|integer',
			'employee_id' => 'required|integer',
			'datetime' => 'required|date',
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

	public function oos_details()
	{
		return $this->hasMany(OosDetail::class);
	}

	public function getOosItemsAttribute()
	{
		return $this->oos_details;
	}

	public function syncPF()
	{
		foreach ($this->oos_details as $oosDetail) {
			$oosDetail->syncPF(true);
		}

		return $this;
	}
}
