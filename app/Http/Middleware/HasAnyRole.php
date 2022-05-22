<?php

namespace App\Http\Middleware;

use App\Traits\Data;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class HasAnyRole
{
    use Data;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$roles)
    {
        $guard = Data::guard();
        $authGuard = app('auth')->guard($guard);

        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($roles)
            ? $roles
            : explode('|', $roles);

//        $allRoles=Role::where('guard_name','=',$guard)->pluck('name')->toArray();
        $userRoles=$authGuard->user()->roles()->pluck('name')->toArray();
        foreach ($roles as $role) {
            if (in_array(self::all_lower_case($role),$userRoles)) {
                return $next($request);
            }
        }
        throw UnauthorizedException::forRoles($roles);
    }
}
