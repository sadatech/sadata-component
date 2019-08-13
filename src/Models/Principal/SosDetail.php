<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Traits\RestrictData;
use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosDetail extends PrincipalModel
{

	use SoftDeletes, RestrictData;

	protected $guarded = [];
	protected $table = 'sos_detail';
	protected $header = 'sos_header';

	public static function rule()
	{
		return [
			'sos_header_id' => 'required|integer',
			'product_id' => 'required|integer',
			'value' => 'required|integer',
			'is_pf' => 'required|integer'
		];
	}

	public function sos_header()
	{
		return $this->belongsTo(SosHeader::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function getDatetimeAttribute() { return $this->sos_header->datetime; }

	public function getEmployeeAttribute() { return $this->sos_header->employee; }
	public function getEmployeeNameAttribute() { return $this->employee->name; }
	public function getStoreAttribute() { return $this->sos_header->store; }
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
