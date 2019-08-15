<?php

namespace Sada\SadataComponent\Middlewares;

use Sada\SadataComponent\Models\Main\Permission;
use Sada\SadataComponent\Models\Main\Roles;
use Closure;

class UserPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();
        $routeName = \Route::currentRouteName();

        if (!($user->role_id == Roles::SUPER_ADMIN || $user->hasPermissionTo($routeName) || $user->role->hasPermissionTo($routeName))) {
            $alert = [
                'type' => 'error', // [SUCCESS, INFO, WARNING, ERROR]
                'title' => 'Access Denied.',
                'msg' => "Sorry, You don't have permission for this request :(",
            ];

            if ($request->wantsJson()) {
                return response()->json($alert, 401);
            }

            $lastPage = url()->previous();
            return redirect($lastPage == url()->current() ? '/' : $lastPage)->with('alert', $alert);
        }

        return $next($request);
    }
}
