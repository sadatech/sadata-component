<?php

namespace Sada\SadataComponent\Middlewares;

use Sada\SadataComponent\Models\Main\Roles;
use Sada\SadataComponent\Models\Principal\Employee;
use Closure;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class UserGate
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
        if (!empty(auth()->user()->company_id)) {
            if(auth()->user()->company->connected()){
                if ($request->wantsJson()){
                    //CHECK IF NOT DESKTOP USER
                    $agent = new Agent();

                    if(!$agent->isDesktop()){
                        if(auth()->user()->api_login != 1){
                            return response()->json(['status' => false, 'msg' => 'You session has expired. Please login again.'], 500);
                        }
                    }
                    
                }else{
                    if(auth()->user()->web_login != 1){
                        Auth::logout();
                        return redirect('/login');
                    }
                }

            }
        }

        return $next($request);
    }
}
