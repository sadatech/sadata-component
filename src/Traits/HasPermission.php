<?php

namespace Sada\SadataComponent\Traits;

use Sada\SadataComponent\Models\Principal\Permission;
use Sada\SadataComponent\Models\Principal\HasPermission as HasPermissionModel;
use Illuminate\Support\Facades\DB;

trait HasPermission {

    public function hasPermissionTo($request = null)
    {
        $request = $request ?? \Route::currentRouteName();

        $permission = Permission::whereRequest($request)->first();

        if ($permission) {
            return HasPermissionModel::whereRequest($request)
                                    ->whereBasedOnId($this->id)
                                    ->whereBasedOnType(self::class)
                                    ->count() > 0 && !$permission->exclude ? true : false;
        }

        return true;
    }

    public function queries()
    {
        return HasPermissionModel::whereBasedOnId($this->id)->whereBasedOnType(self::class);
    }

    public function getPermissionsAttribute()
    {
        $request = $this->queries()->select('request')->get()->pluck('request');

        return Permission::whereIn('request', $request)->get();
    }

    public function syncPermissions($newPermissions)
    {
        $oldPermissions = $this->permissions->pluck('request');
        $newPermissions = collect($newPermissions);
        $deletedPermissions = $oldPermissions->diff($newPermissions);
        $addedPermissions = $newPermissions->diff($oldPermissions);

        DB::transaction(function () use($deletedPermissions, $addedPermissions) {
            $this->queries()->whereIn('request', $deletedPermissions)->delete();

            foreach ($addedPermissions as $permission) {
                HasPermissionModel::create([
                    'request' => $permission,
                    'based_on_id' => $this->id,
                    'based_on_type' => self::class
                ]);
            }
        });

        return $this->permissions;
    }

    public function givePermissionTo($permission)
    {
        HasPermissionModel::create([
            'request' => $permission,
            'based_on_id' => $this->id,
            'based_on_type' => self::class
        ]);
    }

}
