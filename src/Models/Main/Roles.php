<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Traits\HasPermission;
use Sada\SadataComponent\Models\MainModel;
use Sada\SadataComponent\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends MainModel
{
	use SoftDeletes;
	use HasPermission;

	const EMPLOYEE = 10;
	const TEAM_LEADER = 20;
	const SUPERVISOR = 30;
	const ADMIN = 40;
	const SUPER_ADMIN = 99;

	protected $guarded = [];

	public static function rule($company)
	{
		return [
			'name' => 'required|string|unique:roles,name,' . $company->id,
		];
	}

	public static function get()
	{
		$roles = [
			self::EMPLOYEE => 'EMPLOYEE',
			self::TEAM_LEADER => 'TEAM LEADER',
			self::SUPERVISOR => 'SUPERVISOR',
			self::ADMIN => 'ADMIN',
			self::SUPER_ADMIN => 'SUPER_ADMIN'
		];

		if (auth()->user()->role_id != self::SUPER_ADMIN) {
			unset($roles[self::SUPER_ADMIN], $roles[self::ADMIN]);
		}

		return $roles;
	}

	public function getStatus($status_id = null){
		$status = [
			self::EMPLOYEE => 'EMPLOYEE',
			self::TEAM_LEADER => 'TEAM_LEADER',
			self::SUPERVISOR => 'SUPERVISOR',
			self::ADMIN => 'ADMIN',
			self::SUPER_ADMIN => 'SUPER_ADMIN'
		];

		return $status_id ? $status[$status_id] : $status[$this->status_id];
	}

	public function users(){
        return $this->hasMany(User::class);
    }

}
