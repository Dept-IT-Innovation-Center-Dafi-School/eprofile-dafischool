<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Vite's dev server serves scripts/HMR from a different origin
        // (e.g. localhost:5173), which a production-strength CSP would
        // block outright — apply it only outside local development.
        if (! app()->environment('local')) {
            $response->headers->set(
                'Content-Security-Policy',
                "default-src 'self'; ".
                "script-src 'self' 'unsafe-eval'; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; ".
                "img-src 'self' data: https:; ".
                "font-src 'self' data: https://fonts.gstatic.com; ".
                "connect-src 'self'; ".
                "frame-ancestors 'none';"
            );
        }

        return $response;
    }
}
