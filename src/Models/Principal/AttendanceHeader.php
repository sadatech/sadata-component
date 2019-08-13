<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceHeader extends PrincipalModel
{
    use SoftDeletes;

    protected $appends = ['status_explain', 'is_rejected_explain', 'employee_name',  'employee_nip'];
	protected $hidden = ['employee'];
	protected $guarded = [];
	protected $table = 'attendance_header';

    const WORK = 10;
    const PERMISSION = 20;
    const OFF = 30;

	public static function rule()
	{
		return [
			'employee_id' => 'required|integer',
			'date' => 'required|date',
			'status' => 'required|string',			
			'is_rejected' => 'nullable|string'
		];
	}

	public function detail()
	{
		return $this->hasMany(AttendanceDetail::class, 'attendance_header_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}

	public static function getStatusList($status_id = null)
    {
        $status = [
            self::WORK => 'Work',
            self::PERMISSION => 'Permission',
            self::OFF => 'Off',
        ];

        return $status_id ? $status[$status_id] : $status;
    }

    public function getStatus($status_id = null){
		return $status_id ? $this->getStatusList($status_id) : $this->getStatusList($this->status_id);
	}

	public function getStatusExplainAttribute(){
		return $this->getStatus($this->status);
	}

	public function getIsRejectedExplainAttribute(){
		return ($this->is_rejected == 1) ? "REJECTED" : "APPROVED";
	}

	// EMPLOYEE ATTRIBUTE
	public function getEmployeeNameAttribute(){ return $this->employee->name; }
	public function getEmployeeNipAttribute(){ return $this->employee->nip; }

	public function getReportTemplate($search, $type){
		$template = [
			'status' => ['Alpha', 'Work', 'Permission', 'Off'],
			'color' => ['#F22D4E','#2CA189', '#FBAA00', '#93959b'],
			'text' => ['#ecf0f1', '#ecf0f1', '#ecf0f1', '#ecf0f1']
		];

		return $template[$type][array_search($search, $template['status'])];
	}
}
