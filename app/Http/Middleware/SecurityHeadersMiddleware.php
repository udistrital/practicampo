<?php

namespace PractiCampoUD\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = "default-src 'self'; " .
               "style-src 'self' 'unsafe-inline' cdn.jsdelivr.net cdn.datatables.net; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' code.jquery.com cdn.jsdelivr.net cdn.datatables.net; " .
               "font-src 'self' cdn.jsdelivr.net; " .
               "img-src 'self' data:; " .
               "connect-src 'self';";
        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer');

        return $response;
    }
}
