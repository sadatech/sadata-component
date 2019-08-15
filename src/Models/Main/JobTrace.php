<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Models\MainModel;
use Sada\SadataComponent\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTrace extends MainModel
{
	const STATUS_ON_PROCESS = 'ON PROCESS';
	const STATUS_SUCCESS = 'SUCCESS';
	const STATUS_FAILED = 'FAILED';

	use SoftDeletes;

	protected $guarded = [];

	public static function rule($company)
	{
		return [
		];
	}

	public static function boot()	
	{
        parent::boot();
		
		self::creating(function($model){
			$model->created_by = \Auth::id() ?? 0;
			$model->company_id = \Auth::user()->company_id;
        });
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by')->with('role');
	}

	public function scopeMode($query, $param)
	{
		return $query->where('mode', $param);
	}
}
