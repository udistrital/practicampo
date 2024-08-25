<?php

namespace PractiCampoUD\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Estudiante
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
        if (Auth::guard('estud')->check()) {
            return $next($request);
        }
        else 
        {
            Abort('999');
        }

        
    }
}
