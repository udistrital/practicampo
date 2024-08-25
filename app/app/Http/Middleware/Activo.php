<?php

namespace PractiCampoUD\Http\Middleware;

use Closure;

class Activo
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
        if($request->user()->activo())
        {
            return $next($request);
        }

        else 
        {
            Abort('401');
        }
    }
}
