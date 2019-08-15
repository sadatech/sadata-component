<?php

namespace Sada\SadataComponent\Middlewares;

use Sada\SadataComponent\Models\Main\Roles;
use Closure;

class SuperAdmin
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
        if (!empty(auth()->user()->role_id)) {
            if(auth()->user()->role_id == Roles::SUPER_ADMIN){
                return $next($request);
            }
        }

        return redirect('/');        
    }
}
