<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Traits\HasPermission;
use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Models\Principal\AttendanceHeader;
use Sada\SadataComponent\Models\Principal\EmployeeStore;
use Sada\SadataComponent\Models\Principal\EmployeeTeam;
use Sada\SadataComponent\Traits\ActivityTrait;
use Sada\SadataComponent\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends PrincipalModel
{

    use SoftDeletes, ActivityTrait, HasPermission;

	protected $guarded = ['username', 'email', 'password', 'role_id'];

	const ACTIVE = 10;
    const RESIGN = 20;

    protected static function boot()
    {
        parent::boot();

        /* LOGGING */
        static::creating(function ($data) {
            $data->logCreatedActivity($data, [
                    'name' => $data->name,
                    'nip' => $data->nip,
                    'nik' => $data->nik,
                    'phone' => $data->phone,
                    'bank_name' => $data->bank_name,
                    'bank_account_number' => $data->bank_account_number,
                    'join_at' => $data->join_at,
                    'birthdate' => $data->birthdate,
                    'gender' => $data->gender,
                    'education' => $data->education,
                    'ktp_photo' => $data->ktp_photo,
                    'bank_account_photo' => $data->bank_account_photo,
                    'profile_photo' => $data->profile_photo,
                    'status_id' => $data->status_id,
                    'email' => $data->user->email,
                    'username' => $data->user->name,
                    'role' => $data->user->role->name,
            ]);
        });

        static::updating(function ($data) {
            $data->logUpdatedActivity($data, [
                'old' => [
                    'name' => $data->fresh()->name,
                    'nip' => $data->fresh()->nip,
                    'nik' => $data->fresh()->nik,
                    'phone' => $data->fresh()->phone,
                    'bank_name' => $data->fresh()->bank_name,
                    'bank_account_number' => $data->fresh()->bank_account_number,
                    'join_at' => $data->fresh()->join_at,
                    'birthdate' => $data->fresh()->birthdate,
                    'gender' => $data->fresh()->gender,
                    'education' => $data->fresh()->education,
                    'ktp_photo' => $data->fresh()->ktp_photo,
                    'bank_account_photo' => $data->fresh()->bank_account_photo,
                    'profile_photo' => $data->fresh()->profile_photo,
                    'status_id' => $data->fresh()->status_id,
                    'email' => $data->fresh()->user->email,
                    'username' => $data->fresh()->user->name,
                    'role' => $data->fresh()->user->role->name,
                ],
                'new' => [
                    'name' => $data->name,
                    'nip' => $data->nip,
                    'nik' => $data->nik,
                    'phone' => $data->phone,
                    'bank_name' => $data->bank_name,
                    'bank_account_number' => $data->bank_account_number,
                    'join_at' => $data->join_at,
                    'birthdate' => $data->birthdate,
                    'gender' => $data->gender,
                    'education' => $data->education,
                    'ktp_photo' => $data->ktp_photo,
                    'bank_account_photo' => $data->bank_account_photo,
                    'profile_photo' => $data->profile_photo,
                    'status_id' => $data->status_id,
                    'email' => $data->user->email,
                    'username' => $data->user->name,
                    'role' => $data->user->role->name,
                ]
            ]);
        });

        static::deleting(function ($data) {
            $data->logDeletedActivity($data, [
                    'name' => $data->name,
                    'nip' => $data->nip,
                    'nik' => $data->nik,
                    'phone' => $data->phone,
                    'bank_name' => $data->bank_name,
                    'bank_account_number' => $data->bank_account_number,
                    'join_at' => $data->join_at,
                    'birthdate' => $data->birthdate,
                    'gender' => $data->gender,
                    'education' => $data->education,
                    'ktp_photo' => $data->ktp_photo,
                    'bank_account_photo' => $data->bank_account_photo,
                    'profile_photo' => $data->profile_photo,
                    'status_id' => $data->status_id,
                    'email' => $data->user->email,
                    'username' => $data->user->name,
                    'role' => $data->user->role->name,
            ]);
        });
    }

    public static function rule()

	{
		return [
			'user_id' => 'nullable|integer',
			'name' => 'required|string',
			'address' => 'required|string',
			'nip' => 'nullable|string',
			'nik' => 'nullable|string',
			'phone' => 'nullable|string',
			'bank_name' => 'nullable|string',
			'bank_account_number' => 'nullable|string',
			'join_at' => 'nullable|date',
			'birthdate' => 'nullable|date',
			'gender' => 'nullable|string',
			'education' => 'nullable|string',
			'ktp_photo' => 'nullable|string',
			'bank_account_photo' => 'nullable|string',
			'profile_photo' => 'nullable|string',
			'status_id' => 'nullable|integer',
		];
	}

    public static function getStatusList($status_id = null)
    {
        $status = [
            self::ACTIVE => 'ACTIVE',
            self::RESIGN => 'RESIGN',
        ];

        return $status_id ? $status[$status_id] : $status;
    }

    public function getStatus($status_id = null){
		return $status_id ? $this->getStatusList($status_id) : $this->getStatusList($this->status_id);
	}

	public function user()
    {
        return $this->belongsTo(User::class)->with('role');
    }

    public function employeeStores()
    {
      return $this->hasMany(EmployeeStore::class, 'employee_id');
    }

    public function employeeTeams()
    {
        return $this->hasMany(EmployeeTeam::class, 'member_id');
    }

    public function attendanceHeaders()
    {
      return $this->hasMany(AttendanceHeader::class, 'employee_id');
    }

    public function scopeNoAdmin($query)
    {
        return $query->whereHas('user', function($q){
            return $q->whereNotIn('role_id', [Roles::ADMIN, Roles::SUPER_ADMIN]);
        });
    }

    public function scopeNotSelf($query)
    {
        return $query->whereHas('user', function($q){
            return $q->whereNotIn('id', auth()->user()->id);
        });
    }

    public function scopeActive($query)
    {
        return $query->whereStatusId(Employee::ACTIVE);
    }

    public function getEducationAttribute($value)
    {
        return collect(json_decode($value))->toArray();
    }

    public function getStoreIdsAttribute(){
      return $this->employeeStores()->pluck('store_id')->toArray();
    }

    public function getTeamStoreIdsAttribute(){
      return EmployeeStore::whereIn('employee_id', $this->teams->pluck('id')->toArray())->pluck('store_id')->toArray();
    }

    public function getTeamsAttribute()
    {
        $query = $this->join('employee_team AS et', 'employees.id', '=', 'et.leader_id')
                    ->join('employees AS e', 'et.member_id', '=', 'e.id')
                    ->where('et.deleted_at', null)
                    ->where('e.deleted_at', null)
                    ->where('e.status_id', 10)
                    ->where('employees.id', $this->id)
                    ->select('et.id as employee_team_id', 'employees.id as leader_id', 'e.*');
        
        return $query->get();
    }

    public function team_leader_relation()
    {
        return $this->hasOne(EmployeeTeam::class, 'member_id');
    }

    public function getTeamLeaderAttribute()
    {
        return @$this->team_leader_relation->leader;
    }

    public function getStoresAttribute()
    {
        return $this->getStoresQueryAttribute()->simple();
    }

    public function getEmployeeStoresAttribute()
    {
         return $this->getStoresQueryAttribute()->get();
    }

    public function getStoresQueryAttribute()
    {
        $employee_relation_id = [$this->id];

        if ($this->user->role_id == Roles::TEAM_LEADER) {
            $employee_relation_id = array_merge($employee_relation_id, $this->teams->pluck('id')->toArray());
        }

        $stores = EmployeeStore::join('stores AS s', 'employee_store.store_id', '=', 's.id')
              ->join('employees AS em', 'em.id', '=', 'employee_store.employee_id')
              ->where('employee_store.deleted_at', null)
              ->where('s.deleted_at', null)
              ->where('employee_store.date_out', null)
              ->where('em.status_id', 10)
              ->whereIn('em.id', $employee_relation_id)
              ->select('employee_store.date_in', 'employee_store.date_out', 'employee_store.status', 'employee_store.store_id', 's.*');

        return $stores;
    }

    public function employee_stores()
    {
        return $this->hasMany(EmployeeStore::class);
    }

    public function getWorkingDays($range = [])
    {
        return $this->attendanceHeaders->where('date', '>=', $range[0])->where('date', '<=', $range[1])->count();
    }

    public function getAttendances($date1, $date2)
    {
        $dataDetail = AttendanceHeader::where('date', '>=', $date1)
                                      ->where('date', '<=', $date2)
                                      ->where('employee_id', $this->id)
                                      ->get();

        $statusAttendance = [];
        $idAttendance = [];
        $dateAttendance = [];

        foreach ($dataDetail as $data) {
            $statusAttendance[] = $data->getStatus($data->status);
            $idAttendance[] = $data->id;
            $date = explode('-',$data->date);
            $dateAttendance[] = $date[2];
        }

        return [
            'status_attendance' => $statusAttendance,
            'id_attendance' => $idAttendance,
            'date_attendance' => $dateAttendance,
        ];
    }

    public function getAttendanceBy($date)
    {
        // DEFAULT ALPHA
        $result['status'] = 'Alpha';
        $result['bgColor'] = '#F22D4E';
        $result['txColor'] = '#ecf0f1';

        // WHEN NOT JOINED
        if($date < $this->join_at){
            $result['status'] = 'Not Joined';
            $result['bgColor'] = '#93959b';
        }else{

            // IF MORE THAN NOW
            if($date > \Carbon\Carbon::now()){

                $result['more'] = 1;

            }else{

                // GET DATA
                $data = $this->attendanceHeaders->where('date', $date)->first();

                if($data){
                    $result['status'] = $data->getStatus($data->status);
                    $result['bgColor'] = $data->getReportTemplate($result['status'], 'color');
                    $result['txColor'] = $data->getReportTemplate($result['status'], 'text');

                    // IF REJECTED HEADER
                    $result['reject'] = ($data->is_rejected == 1) ? 1 : 0;

                    // IF REJECTED DETAIL
                    $result['rejectDetail'] = $data->detail->where('is_rejected', 1)->count();

                    // CHECK FOR WORK
                    $result['work'] = (($result['status'] == 'Work') || ($result['status'] == 'Permission')) ? $result['status'] : null;

                    // ID
                    $result['data_id'] = $data->id;
                }

            }
        }

        return $result;
    }

    public function attendance_detail()
    {
        return $this->hasManyThrough(AttendanceDetail::class, AttendanceHeader::class);
    }

    public function supervisors()
    {
        return $this->hasMany(EmployeeSupervisor::class);
    }

    public function supervisoring($data)
    {
        $oldSupervisor = $this->supervisors;
        $newSupervisor = collect();

        foreach ($data as $value) {
            $employeeSupervisor = EmployeeSupervisor::updateOrCreate([
                'id' => $value['id']
            ], [
                'employee_id' => $this->id,
                'area_schema' => @$value['area_schema'],
                'channel_schema' => @$value['channel_schema'],
                'product_schema' => @$value['product_schema']
            ]);

            $newSupervisor->push($employeeSupervisor);
        }

        $deletedSupervisor = $oldSupervisor->diff($newSupervisor)->pluck('id');
        EmployeeSupervisor::whereIn('id', $deletedSupervisor)->delete();
    }

}
