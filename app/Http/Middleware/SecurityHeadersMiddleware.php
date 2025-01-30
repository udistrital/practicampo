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
               "script-src 'self' 'unsafe-inline' code.jquery.com cdn.jsdelivr.net cdn.datatables.net cdnjs.cloudflare.com maps.googleapis.com; " .
               "font-src 'self' cdn.jsdelivr.net; " .
               "img-src 'self' data:; " .
               "connect-src 'self' maps.googleapis.com;";
        $response->headers->set('Content-Security-Policy', $csp, true);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', true);
        $response->headers->set('X-XSS-Protection', '1; mode=block', true);
        $response->headers->set('X-Content-Type-Options', 'nosniff', true);
        $response->headers->set('Referrer-Policy', 'no-referrer', true);
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains', true);

        return $response;
    }
}
