<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceDetail extends PrincipalModel
{
    use SoftDeletes;

    protected $appends = ['store_code', 'store_name', 'store_alias_name', 'store_is_office', 'is_rejected_explain'];
	protected $guarded = [];
	protected $hidden = ['store'];
	protected $table = 'attendance_detail';


	public static function rule()
	{
		return [
			'attendance_id' => 'required|integer',
			'store_id' => 'required|integer',
			'check_in' => 'nullable|date_format:H:i:s',
			'check_out' => 'nullable|date_format:H:i:s',
			'check_in_longitude' => 'nullable|numeric',
			'check_in_latitude' => 'nullable|numeric',
			'check_out_longitude' => 'nullable|numeric',
			'check_out_latitude' => 'nullable|numeric',
			'check_in_location' => 'nullable|string',
			'check_out_location' => 'nullable|string',
			'is_rejected' => 'nullable|string',
			'photo' => 'nullable|string'
		];
	}

	public function header()
	{
		return $this->belongsTo(AttendanceHeader::class, 'attendance_header_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class, 'store_id');
	}

	public function getIsRejectedExplainAttribute(){
		return ($this->is_rejected == 1) ? "REJECTED" : "APPROVED";
	}

	// STORE ATTRIBUTE
	public function getStoreCodeAttribute(){ return $this->store->code; }
	public function getStoreNameAttribute(){ return $this->store->name; }
	public function getStoreAliasNameAttribute(){ return $this->store->alias_name; }
	public function getStoreIsOfficeAttribute(){ return ($this->store->is_office == 1) ? "OFFICE" : "STORE"; }
}
