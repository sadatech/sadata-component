<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoHeader extends PrincipalModel
{

	use SoftDeletes;

	protected $guarded = [];
	protected $table = 'promo_header';

	public static function rule()
	{
		return [
			'store_id' => 'required|integer',
			'employee_id' => 'required|integer',
			'datetime' => 'required|date',
			'start_date' => 'required|date',
			'end_date' => 'required|date',
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

	public function promo_details()
	{
		return $this->hasMany(PromoDetail::class);
	}

	public function getPromoItemsAttribute()
	{
		return $this->promo_details;
	}

	public function syncPF()
	{
		foreach ($this->promo_details as $promoDetail) {
			$promoDetail->syncPF(true);
		}

		return $this;
	}
}
