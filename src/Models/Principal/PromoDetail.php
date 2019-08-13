<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Traits\RestrictData;
use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoDetail extends PrincipalModel
{

	use SoftDeletes, RestrictData;

	protected $guarded = [];
	protected $table = 'promo_detail';
	protected $header = 'promo_header';

	public static function rule()
	{
		return [
			'promo_header_id' => 'required|integer',
			'product_id' => 'required|integer',
			'photo' => 'required|string'
		];
	}

	public function promo_header()
	{
		return $this->belongsTo(PromoHeader::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function getDatetimeAttribute() { return $this->promo_header->datetime; }

	public function getEmployeeAttribute() { return $this->promo_header->employee; }
	public function getEmployeeNameAttribute() { return $this->employee->name; }
	public function getStoreAttribute() { return $this->promo_header->store; }
	public function getStoreNameAttribute() { return $this->store->name; }

	public function syncPF($autoSave = false)
	{
		$this->is_pf = $this->isActivePF();
		
		if ($autoSave) {
			$this->save();
		}

		return $this;
	}
}
