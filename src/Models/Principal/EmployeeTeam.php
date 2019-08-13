<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class EmployeeTeam extends PrincipalModel
{

	use SoftDeletes;

	protected $guarded = [];
	protected $table = 'employee_team';

	public static function rule()
	{
		return [
			'leader_id' => 'required|string',
			'member_id' => 'required|integer',
		];
	}

	public function leader()
	{
		return $this->belongsTo(Employee::class, 'leader_id');
	}

	public function member()
	{
		return $this->belongsTo(Employee::class, 'member_id');
	}
}
