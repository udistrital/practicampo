<?php
namespace PractiCampoUD\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ValidateTokenMiddleware
{
    /**
     * Maneja la expiración del token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
     $expiracion_token = session('expires_in');
        //dd(session('expires_in'));
        if ($expiracion_token && now()->greaterThanOrEqualTo(Carbon::parse($expiracion_token))) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken(); 
            session()->flush();

            return redirect()->route('login')->with('error','Su sesión ha expirado. Ingresa nuevamente.');
        }

    return $next($request);
    }
}
