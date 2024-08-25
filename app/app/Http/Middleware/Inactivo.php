<?php

namespace PractiCampoUD\Http\Middleware;

use Closure;

class Inactivo
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
        if($request->user()->inactivo())
        {
            return $next($request);
        }

        else 
        {
            Abort('401');
        }
    }
}
