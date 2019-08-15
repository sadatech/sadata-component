<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Models\MainModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends MainModel
{
	use SoftDeletes;

	protected $guarded = [];

	public static function rule($company)
	{
		return [

		];
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function billDate($formatted = true)
	{
		$date = Carbon::parse($this->bill_date);
		$format = $this->invoice->subscribe_period == 'PER YEAR' ? 'F Y' : 'F d, Y';

		return $formatted ? $date->format($format) : $date;
	}
}
