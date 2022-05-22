<?php

namespace App\Traits;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

trait Authorize
{
    public function permission($permissions, $guard = null)
    {
        $guard = Data::guard();
        $authGuard = app('auth')->guard($guard);

        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permissions)
            ? $permissions
            : explode('|', $permissions);

        $UserRoles=$authGuard->user()->roles()->pluck('name')->toArray();
        $UserPermissions=$authGuard->user()->getAllPermissions()->where('guard_name',$guard)->pluck('name')->toArray();
        foreach ($permissions as $permission) {
            if (in_array($permission,$UserPermissions)) {
                return true;
            }
        }
        return false;
    }

    public function permissionID($permission,$guard = null){
        $guard = Data::guard();
        $authGuard = app('auth')->guard($guard,);
        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        dd($permission);
    }
}
