<?php

namespace Sada\SadataComponent\Models\Principal;

use Sada\SadataComponent\Models\PrincipalModel;
use Sada\SadataComponent\Models\Principal\Employee;
use Sada\SadataComponent\Models\Principal\Store;
use Sada\SadataComponent\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeStore extends PrincipalModel
{

	use SoftDeletes, ActivityTrait;

	protected $guarded = [];
	protected $table = 'employee_store';

	// STATUS APPROVAL
	const APPROVED = 10;
    const TEMPORARY = 30;
    const TEMPORARY_ADMIN = 40;
    const REJECTED = 50;

    protected static function boot()
	{
	    parent::boot();

	 	/* LOGGING */
	 	static::creating(function ($data) {
	 		$data->logCreatedActivity($data, [
	 				'employee' => $data->employee,
	 				'store' =>$data->store,
	 				'date_in' =>$data->date_in,
	 				'date_out' =>$data->date_out,
	 				'status' =>$data->getStatus($data->status),
	 		]);
	 	});

	 	static::updating(function ($data) {
	 		$data->logUpdatedActivity($data, [
	 			'old' => [
	 				'employee' => $data->fresh()->employee,
	 				'store' =>$data->fresh()->store,
	 				'date_in' =>$data->fresh()->date_in,
	 				'date_out' =>$data->fresh()->date_out,
	 				'status' =>$data->fresh()->getStatus($data->status),
	 			],
	 			'new' => [
	 				'employee' => $data->employee,
	 				'store' =>$data->store,
	 				'date_in' =>$data->date_in,
	 				'date_out' =>$data->date_out,
	 				'status' =>$data->getStatus($data->status),
	 			]
	 		]);
	 	});

	 	static::deleting(function ($data) {
	 		$data->logDeletedActivity($data, [
	 				'employee' => $data->employee,
	 				'store' =>$data->store,
	 				'date_in' =>$data->date_in,
	 				'date_out' =>$data->date_out,
	 				'status' =>$data->getStatus($data->status),
	 		]);
	 	});
	}

	public static function rule()
	{
		return [
			'employee_id' => 'required|string',
			'store_id' => 'required|integer',
			'date_in' => 'required|date',
			'date_out' => 'nullable|integer',
			'status' => 'required|string'
		];
	}

	public static function getStatusList($status_id = null)
    {
        $status = [
            self::APPROVED => 'APPROVED',
            self::TEMPORARY => 'TEMPORARY',
            self::TEMPORARY_ADMIN => 'TEMPORARY FOR ADMIN',
            self::REJECTED => 'REJECTED',
        ];

        return $status_id ? $status[$status_id] : $status;
    }

    public function getStatus($status_id = null){
		return $status_id ? $this->getStatusList($status_id) : $this->getStatusList($this->status);
	}

	public function getStatusExplainAttribute(){
		return $this->getStatus($this->status);
	}	

	public function store()
	{
		return $this->belongsTo(Store::class, 'store_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}

	// ATTRIBUTE FROM STORE
	public function getAreaScopeAttribute(){ return $this->store->area_scope; }
    public function getChannelScopeAttribute(){ return $this->store->channel_scope; }
    public function getIsOfficeExplainAttribute(){ return $this->store->is_office_explain; }

    public function scopeNeedAction($query)
    {
        return $query->where('status', '!=', self::APPROVED);
    }

    public function migrateStore($toStoreId)
    {
    	$employeeStore = $this; 

    	DB::transaction(function () use($employeeStore, $toStoreId) {
    		$dateRange = [$employeeStore->date_in, $employeeStore->date_out ?? date('Y-m-d')];

	    	AttendanceDetail::where('store_id', $employeeStore->store_id)
	                        ->whereHas('header', function($q) use($employeeStore, $dateRange) {
	                            $q->whereEmployeeId($employeeStore->employee_id)
	                              ->whereBetween('date', $dateRange);
	                        })->update(['store_id' => $toStoreId]);

	        $salesHeader = SalesHeader::whereEmployeeId($employeeStore->employee_id) 
	        						  ->whereStoreId($employeeStore->store_id)
	        						  ->whereBetween('datetime', $dateRange);
	        $salesHeader->update(['store_id' => $toStoreId]);
	        $salesHeader->get()->each(function($item){
	        	$item->syncPF();
	        });

	        $employeeStore->update(['date_out' => date('Y-m-d')]);
	        $employeeStore->delete();

	        $newEmployeeStore = self::firstOrNew([
	            'employee_id' => $employeeStore->employee_id,
	            'store_id' => $toStoreId
	        ]);

	        if ($newEmployeeStore->isNewRecord()) {
	            $newEmployeeStore->fill(['date_in' => $employeeStore->date_in])->save();
	        }
    	});
    }
}
