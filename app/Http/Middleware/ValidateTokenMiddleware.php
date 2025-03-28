<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jumbojett\OpenIDConnectClient;

class ValidateTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $token = session('access_token');

            if (!$token || !$this->validar_token($token)) { //falta realizar pruebas
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Tu sesión ha expirado.'); //validar mensaje de error
            }
        }

        return $next($request);
    }

    private function validar_token($token) //función por validar correctamente
    {
        $oidc = new OpenIDConnectClient(
            env('WSO2_TOKEN_URL'),
            env('WSO2_CLIENT_ID'),
            env('WSO2_CLIENT_SECRET')
        );

        $oidc->providerConfigParam([
            'token_endpoint' => env('WSO2_TOKEN_URL')
        ]);

        try {
            $userInfo = $oidc->introspectToken($token);
            return $userInfo->active ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
