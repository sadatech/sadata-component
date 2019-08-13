<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class Permission extends PrincipalModel
{
	protected $guarded = [];
	protected $table = 'auth_permissions';

}
