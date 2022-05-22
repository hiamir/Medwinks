<?php

namespace App\Http\Middleware;

use App\Traits\Data;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class HasAnyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permissions)
    {
        {
            $guard = Data::guard();
            $authGuard = app('auth')->guard($guard);

            if (Auth::guard($guard)->guest()) {
                throw UnauthorizedException::notLoggedIn();
            }

            $permissions = is_array($permissions)
                ? $permissions
                : explode('|', $permissions);

            $UserPermissions=Auth::guard($guard)->user()->getAllPermissions()->pluck('name')->toArray();
            foreach ($permissions as $permission) {
                if (in_array($permission,$UserPermissions)) {
                    return $next($request);
                }
            }
            throw UnauthorizedException::forPermissions($permissions);
        }
    }
}
