<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Vite;

class AddContentSecurityPolicyHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        Vite::useCspNonce();

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-" . Vite::cspNonce() . "' https://cdn.onesignal.com https://onesignal.com",
            "connect-src 'self' https://cdn.onesignal.com https://onesignal.com",
            "img-src 'self' https://cdn.onesignal.com https://onesignal.com data:",
            "style-src 'self' 'unsafe-inline'",
            "base-uri 'self'",
            "form-action 'self'",
            "media-src 'self'",
            "object-src 'none'",
        ]);

        return $next($request)->withHeaders([
            'Content-Security-Policy' => $csp,
        ]);
    }
}
