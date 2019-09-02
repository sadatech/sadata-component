<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vendor extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];

	public static function rule()
	{
		return [
			'name' => 'required|string',
			'description' => 'required|string'
		];
	}

}
