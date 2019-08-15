<?php

namespace Sada\SadataComponent\Middlewares;

use Closure;

class ReadNotification
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
        if ($request->has('notif_id')) {
            auth()->user()->unreadNotifications()->where('id', $request->notif_id)->update([
                'read_at' => now()
            ]);
        }        

        return $next($request);
    }
}
