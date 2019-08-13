<?php

namespace Sada\SadataComponent\Models;

use Sada\SadataComponent\Filters\QueryFilters;
use Sada\SadataComponent\Menus\MainMenu;
use Sada\SadataComponent\Menus\PrincipalMenu;
use Sada\SadataComponent\Notifications\Notifiable;
use Sada\SadataComponent\Traits\HasPermission;
use Sada\SadataComponent\Models\Main\Company;
use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\Employee;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Activitylog\Traits\CausesActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use Notifiable, CausesActivity, HasPermission, Impersonate;

    protected $connection = 'main';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'position_id', 'nik', 'role_id', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function rule()
    {
        return [
            'username' => 'required|string',
            'password' => 'required',
            'email' => 'required|email',
            'role_id' => 'required|integer'
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Filtering Berdasarakan Request User
     * @param $query
     * @param QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getMenu()
    {
        if ($this->role_id != Roles::SUPER_ADMIN || !empty($this->company_id)) {
            return PrincipalMenu::get();
        }

        return MainMenu::get();
    }
    
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function role(){
        return $this->belongsTo(Roles::class);
    }

    public function isSuperAdmin()
    {
        return $this->role_id == Roles::SUPER_ADMIN;
    }

    public function isEmployee()
    {
        return $this->role_id == Roles::EMPLOYEE;
    }

    public function isTL()
    {
        return $this->role_id == Roles::TEAM_LEADER;
    }

    public function scopeSimple($query){
        return $query->simplePaginate(request()->limit_page)->appends(request()->all());
    }
}
