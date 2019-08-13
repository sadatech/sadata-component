<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasPermission extends PrincipalModel
{
	protected $guarded = [];
	protected $table = 'auth_has_permissions';
}
