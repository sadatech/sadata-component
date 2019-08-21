<?php

namespace Sada\SadataComponent\Filters;

use App\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class LogFilters extends QueryFilters
{

    public function byRequestUser($value) {
        return (!$this->requestAllData($value)) ? $this->builder->whereCauserId($value)->whereCauserType(User::class) : null;
    }

    public function byActivity($value) {
        return (!$this->requestAllData($value)) ? $this->builder->whereDescription($value) : null;
    }

    public function byRequestFrom($value) {
        return (!$this->requestAllData($value)) ? $this->builder->whereRequestFrom($value) : null;
    }

    public function bySubjectModel($value) {
        return (!$this->requestAllData($value)) ? $this->builder->whereSubjectType($value) : null;
    }

    public function byProperties($value = 'all') {
        return (!$this->requestAllData($value)) ? $this->builder->where('properties', 'LIKE', '%'.$value.'%') : null;
    }

    public function byDate($value = 'all')
    {
        if($value == 'all'){
            return null;
        }

        $date = Carbon::parse($value);
        return $this->builder->whereDate('created_at', Carbon::parse($value)->format('Y-m-d'));
    }

}