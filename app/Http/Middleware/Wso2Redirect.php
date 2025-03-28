<?php

namespace PractiCampoUD\Http\Middleware;

use Closure;

class Wso2Redirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        /*if ($request->has('token') && $request->has('id_token')) {
            return redirect()->route('wso2.callback', [
                'token' => $request->query('token'),
                'id_token' => $request->query('id_token')
            ]);
        }*/

        return $next($request);
    }
}
