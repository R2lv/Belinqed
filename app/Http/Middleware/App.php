<?php

namespace App\Http\Middleware;

use Closure;

class App
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

        if($request->hasCookie("lang")) {
            \App::setLocale($request->cookie('lang'));
            $result = $next($request);
        }else {
            $cookie = cookie('lang', 'ka', 20000000, null, null, false, false);
            $result = $next($request)->withCookie($cookie);
        }

        return $result;
    }
}
