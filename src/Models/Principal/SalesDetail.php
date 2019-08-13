<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Traits\RestrictData;
use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDetail extends PrincipalModel
{

	use SoftDeletes, RestrictData;

	protected $guarded = [];
	protected $table = 'sales_detail';
	protected $header = 'sales_header';

	public static function rule()
	{
		return [
			'header_id' => 'required|integer',
			'product_id' => 'required|integer',
			'qty' => 'required|integer',
			'is_pf' => 'nullable|string'
		];
	}

	public function sales_header()
	{
		return $this->belongsTo(SalesHeader::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function scopeInType($query, $param)
	{
		$type = ($param == 1) ? SalesHeader::TYPE_SALES_IN : SalesHeader::TYPE_SALES_OUT;

		return $query->whereHas('sales_header', function($q) use ($type){
			return $q->where('type', $type);
		});
	}

	public function isActivePF()
	{
		return ProductFocus::isActivePF($this->sales_header->store_id, $this->product_id);
	}

	public function syncPF($autoSave = false)
	{
		$this->is_pf = $this->isActivePF();
		
		if ($autoSave) {
			$this->save();
		}

		return $this;
	}

	public function getDateAttribute() { return $this->sales_header->date; }

	public function getEmployeeAttribute() { return $this->sales_header->employee; }
	public function getEmployeeNameAttribute() { return $this->employee->name; }
	public function getStoreAttribute() { return $this->sales_header->store; }
	public function getStoreNameAttribute() { return $this->store->name; }

}
