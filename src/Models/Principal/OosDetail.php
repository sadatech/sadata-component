<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Traits\RestrictData;
use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OosDetail extends PrincipalModel
{

	use SoftDeletes, RestrictData;

	protected $guarded = [];
	protected $table = 'oos_detail';
	protected $header = 'oos_header';

	public static function rule()
	{
		return [
			'oos_header_id' => 'required|integer',
			'product_id' => 'required|integer',
			'is_pf' => 'required|integer'
		];
	}

	public function oos_header()
	{
		return $this->belongsTo(OosHeader::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function getDatetimeAttribute() { return $this->oos_header->datetime; }

	public function getEmployeeAttribute() { return $this->oos_header->employee; }
	public function getEmployeeNameAttribute() { return $this->employee->name; }
	public function getStoreAttribute() { return $this->oos_header->store; }
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
