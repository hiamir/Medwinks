<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionExtends extends Permission
{
    public function permissionRoles(){
        return $this->belongsToMany(Role::class,'role_has_permissions','permission_id');
    }

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value); // now date is a carbon instance
        return $date->diffForHumans(Carbon::now());

    }

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value); // now date is a carbon instance
        return $date->diffForHumans(Carbon::now());

    }
}
