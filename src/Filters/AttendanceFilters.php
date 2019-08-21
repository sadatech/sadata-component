<?php

namespace Sada\SadataComponent\Filters;

use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\AttendanceDetail;
use App\User;

class AttendanceFilters extends QueryFilters
{
    public function byEmployee($value = '')
    {
        return $this->builder->whereId($value);
    }

}