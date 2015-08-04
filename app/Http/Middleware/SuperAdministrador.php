<?php

namespace AccountHon\Http\Middleware;

use Closure;

class SuperAdministrador
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
        if($next):

        endif;
        return $next($request);
    }
}
