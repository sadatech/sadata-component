<?php

namespace Sada\SadataComponent\Filters;

use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\Employee;
use App\User;

class EmployeeFilters extends QueryFilters
{

    public function q($value = "all") {
        return (!$this->requestAllData($value)) ? $this->builder->where('employees.name', 'like', '%'.$value.'%') : null;
    }

    public function leader_id($value)
    {
        $employees_id = Employee::find($value)->teams->pluck('id')->toArray();

        return $this->builder->whereIn('id', $employees_id);
    }

    public function role_id($value)
    {
        return $this->builder->whereHas('user', function($q) use($value){
            $q->whereRoleId($value);
        })->when(request()->has('doesnt_have_tl') && request()->doesnt_have_tl, function($q){
            $q->doesntHave('team_leader_relation');
        });
    }

    public function byName($value = '')
    {
        return $this->builder->where('name', 'LIKE', '%'.$value.'%');
    }

    public function byRole($value = null)
    {
        if ($value !== null) {
            $usersQuery = User::whereRoleId($value);

            $user = auth()->user();
            if ($user->role_id != Roles::SUPER_ADMIN) {
                $usersQuery->whereCompanyId($user->company_id);
            }

            $users = $usersQuery->get();

            return $this->builder->whereIn('user_id', $users->pluck('id'));
        }
    }

    public function byStatus($value = 'all')
    {
        if ($value != 'all') {
            return $this->builder->whereStatusId($value);
        }
    }

    public function noAdmin($value = 'all'){
        if ($value != 'all'){
            return $this->builder->whereHas('user', function($query) use ($value){
                return $query->whereNotIn('role_id', [Roles::ADMIN, Roles::SUPER_ADMIN]);
            }); 
        }
    }

    public function mode($value = 'all'){
        if ($value != 'all'){
            return $this->builder->whereStatusId($value);
        }
    }

    public function filters($value = [])
    {
        foreach ($value as $filter_key => $filter_value) {
            if(method_exists($this, $filter_key)){
                $this->$filter_key($filter_value);
            }            
        }
    }

}