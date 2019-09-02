<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MaintenanceRequest extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	const STATUS_REQUEST_SUBMITTED = 0;
	const STATUS_VENDOR_SELECTED = 1;
	const STATUS_DONE = 100;

	protected $guarded = [];

	public static function rule()
	{
		return [
			'title' => 'required|string',
			'description' => 'required|string',
			'photo' => 'required|image',
			'employee_id' => 'required|integer',
			'store_id' => 'required|integer',
			'vendor_id' => 'nullable|integer' 
		];
	}

	public function getStatus()
	{
		$status = [
			self::STATUS_REQUEST_SUBMITTED => "Waiting for vendor selection",
			self::STATUS_VENDOR_SELECTED => "On process",
			self::STATUS_DONE => "Done",
		];

		return $status[$this->status];
	}

	public function getStatusFormatted()
	{
		$badge = [
            self::STATUS_REQUEST_SUBMITTED => ['m-badge--danger', 'm--font-danger'],
            self::STATUS_VENDOR_SELECTED => ['m-badge--warning', 'm--font-warning'],
            self::STATUS_DONE => ['m-badge--success', 'm--font-success'],
        ];

        return '<span style="width: 100px;"><span class="m-badge '. $badge[$this->status][0] .' m-badge--wide">'. $this->getStatus() .'</span>';
	}

	public function store()
	{
		return $this->belongsTo(Store::class);
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

}
