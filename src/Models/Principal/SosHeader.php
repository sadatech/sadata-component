<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosHeader extends PrincipalModel
{

	use SoftDeletes;

	protected $guarded = [];
	protected $table = 'sos_header';

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

	public function sos_details()
	{
		return $this->hasMany(SosDetail::class);
	}

	public function getSosItemsAttribute()
	{
		return $this->sos_details;
	}

	public function syncPF()
	{
		foreach ($this->sos_details as $sosDetail) {
			$sosDetail->syncPF(true);
		}

		return $this;
	}
}
