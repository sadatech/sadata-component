<?php

namespace Sada\SadataComponent\Models;

use Sada\SadataComponent\Models\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends MainModel
{
	use SoftDeletes;

	const STATUS_WAITING_TRANSFER_RECEIPT_UPLOADED = 0;
	const STATUS_WAITING_PAYMENT_CONFIRMATION = 10;
	const STATUS_DONE = 100;

	protected $guarded = [];

	public static function rule()
	{
		return [
			'paid_for' => 'required|integer'
		];
	}

	public function getStatus($status_id = null)
	{
		$status = [
			self::STATUS_WAITING_TRANSFER_RECEIPT_UPLOADED => 'Waiting transfer receipt uploaded.',
			self::STATUS_WAITING_PAYMENT_CONFIRMATION => 'Waiting payment confirmation.',
			self::STATUS_DONE => 'Done.',
		];

		return $status_id ? $status[$status_id] : $status[$this->status];
	}

	public function getStatusFormatted($value='')
	{
		$badge = [
            self::STATUS_WAITING_TRANSFER_RECEIPT_UPLOADED => ['m-badge--danger', 'm--font-danger'],
            self::STATUS_WAITING_PAYMENT_CONFIRMATION => ['m-badge--warning', 'm--font-warning'],
            self::STATUS_DONE => ['m-badge--success', 'm--font-success'],
        ];

        return '<span style="width: 100px;"><span class="m-badge '. $badge[$this->status][0] .' m-badge--wide">'. $this->getStatus() .'</span>';
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function invoice_items()
	{
		return $this->hasMany(InvoiceItem::class);
	}

	public function getAmountAttribute()
	{
		return $this->invoice_items()->sum('amount');
	}
}
