<?php

namespace Sada\SadataComponent\Models;

use Sada\SadataComponent\Models\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillPayment extends MainModel
{
	use SoftDeletes;

	protected $guarded = [];

	public static function rule($company)
	{
		return [
		];
	}

	public function company()
	{
		$this->belongsTo(Company::class);
	}
}
