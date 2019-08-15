<?php

namespace Sada\SadataComponent\Models\Main;

use Sada\SadataComponent\Models\MainModel;
use Sada\SadataComponent\Models\Principal\Employee;
use Sada\SadataComponent\Models\Principal\Permission;
use Sada\SadataComponent\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Company extends MainModel
{
	use SoftDeletes;

    const SUBSCRIBE_TYPE_PER_USER = 'PER USER';
    const SUBSCRIBE_TYPE_PER_COMPANY = 'PER COMPANY';
    const SUBSCRIBE_PERIOD_PER_MONTH = 'PER MONTH';
    const SUBSCRIBE_PERIOD_PER_YEAR = 'PER YEAR';

	protected $guarded = [];

	public static function rule($company)
	{
		return [
			'name' => 'required|string|unique:companies,name,' . $company->id,
            'subscribe_type' => 'required|string',
            'subscribe_period' => 'required|string',
            'subscribe_price' => 'required|numeric',
            'bill_date' => 'required|date',
            'hostname' => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
		];
	}

    public static function subscribeTypeList()
    {
        return [
            self::SUBSCRIBE_TYPE_PER_USER => 'Per User',
            self::SUBSCRIBE_TYPE_PER_COMPANY => 'Per Company',
        ];
    }

	public function connect()
	{
		principal_connect($this->hostname, $this->username, $this->password, $this->database);
	}

	public function connected()
    {
    	$this->connect();

        $connection = Config::get('database.connections.principal');

        return $connection['username'] == $this->username &&
            $connection['password'] == $this->password &&
            $connection['database'] == $this->database;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bill_payments()
    {
        return $this->hasMany(BillPayment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoice_items()
    {
        return $this->hasManyThrough(InvoiceItem::class, Invoice::class);
    }

    public function getTotalUsersAttribute()
    {
        $this->connect();
        $usersID = $this->users()->whereNotIn('role_id', [Roles::SUPER_ADMIN, Roles::ADMIN])->pluck('id');
        return Employee::whereIn('user_id', $usersID)
                        ->where('status_id', '!=', Employee::RESIGN)
                        ->count();
    }

    public function getPermissionsAttribute()
    {
    	$this->connect();

    	return Permission::all();
    }

    public function getExcludedPermissionsAttribute()
    {
    	$this->connect();

    	return Permission::whereExclude(1)->get();
    }

    public function syncRoutes($allRoutes)
	{
        $availableRoutes = collect(array_keys($allRoutes));
		$registeredRoutes = Permission::pluck('request');

		$addedRoutes = $availableRoutes->diff($registeredRoutes);
        $removedRoutes = $registeredRoutes->diff($availableRoutes);

    	foreach ($addedRoutes as $route) {
	    	Permission::firstOrCreate([
	    		'name' => $allRoutes[$route],
	    		'request' => $route
	    	]);

	    	Roles::find(Roles::ADMIN)->givePermissionTo($route);
    	}

        Permission::whereIn('request', $removedRoutes)->delete();
	}

    public function getOverdueBillsAttribute()
    {
        $periods = $this->getOverdueBillsPeriod();
        $format = $this->subscribe_period == 'PER YEAR' ? 'F Y' : 'F d, Y';

        $bills = [];
        foreach ($periods as $i => $period) {
            $bills[$i]['original_date'] = $period->format('Y-m-d');
            $bills[$i]['display_date'] = $period->format($format);
            $bills[$i]['amount'] = $this->bill_amount;
        }

        return $bills;
    }

    public function getBillAmountAttribute()
    {
        return $this->subscribe_type == self::SUBSCRIBE_TYPE_PER_USER
                ? $this->total_users * $this->subscribe_price
                : $this->subscribe_price;
    }

    public function getOverdueBillsPeriod()
    {
        $multiple = $this->subscribe_period == 'PER YEAR' ? '1 year' : '1 month';
        $format = $this->subscribe_period == 'PER YEAR' ? 'Y' : 'm';

        $lastBill = $this->invoice_items()->orderBy('bill_date', 'desc')->first();
        $lastBillDate = $lastBill
                        ? ($this->subscribe_period == 'PER YEAR' 
                            ? Carbon::parse($lastBill->bill_date)->addYears(1)->format('Y-m-d') 
                            : Carbon::parse($lastBill->bill_date)->addMonths(1)->format('Y-m-d')) 
                        : $this->bill_date;

        $endPeriodDate = $this->subscribe_period == 'PER YEAR'
                         ? date('Y-') . Carbon::parse($this->bill_date)->format('m-d')
                         : date('Y-m-') . Carbon::parse($this->bill_date)->format('d');

        $periods = CarbonPeriod::create($lastBillDate, $multiple, $endPeriodDate)->toArray();

        return $periods;
    }

    public function hasBills()
    {
        return count($this->overdue_bills) > 0;
    }

    // Overdue bills amount + invoice not done amount
    public function getPendingBillAmountAttribute()
    {
        $company = $this;
        $overdueBills = collect($this->overdue_bills)->sum('amount');
        $pendingBills = InvoiceItem::whereHas('invoice', function($q) use($company){
                            $q->whereCompanyId($company->id)
                              ->where('status', '<', Invoice::STATUS_DONE);
                        })->sum('amount');

        return $overdueBills + $pendingBills;
    }
}
