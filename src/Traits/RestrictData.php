<?php

namespace Sada\SadataComponent\Traits;

use Sada\SadataComponent\Models\Main\Roles;

trait RestrictData {

	public function newQuery($excludeDeleted = true) {
        $user = auth()->user();
        $query = parent::newQuery($excludeDeleted);

        if ($user->role_id == Roles::SUPERVISOR) {
            $query->whereHas($this->header . '.store', function($q) use($user) {
                foreach ($user->employee->supervisors as $sv) {
                    if (!empty($sv->area_schema)) $q->where('stores.area_schema', 'LIKE', "%$sv->area_schema%");
                    if (!empty($sv->channel_schema)) $q->where('stores.channel_schema', 'LIKE', "%$sv->channel_schema%");
                }
            });

            $query->whereHas('product', function($q) use($user) {
                foreach ($user->employee->supervisors as $sv) {
                    if (!empty($sv->product_schema)) $q->where('schema', 'LIKE', "%$sv->product_schema%");
                }
            });
        } 

        else if ($user->role_id == Roles::TEAM_LEADER){
            return $query->whereHas($this->header, function($q) use($user) {
                $q->whereIn('employee_id', $user->employee->teams->pluck('id'));
            });
        }

        return $query;
    }

}
