<?php

namespace Sada\SadataComponent\Filters;

use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\Employee;
use App\User;

class PermissionFilters extends QueryFilters
{

    public function q($value = "all") {
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    }

}