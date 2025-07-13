<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\View;

class AddContentSecurityPolicyHeaders
{
    public function handle($request, Closure $next)
    {
        // Aktifkan penggunaan CSP nonce untuk Vite
        Vite::useCspNonce();

        // Ambil nonce dari Vite
        $nonce = Vite::cspNonce();

        // Bagikan nonce ke seluruh view agar bisa dipakai di Blade
        View::share('csp_nonce', $nonce);

        // Bangun Content-Security-Policy header
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-$nonce' https://cdn.onesignal.com https://onesignal.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' https://cdn.jsdelivr.net https://fonts.gstatic.com",
            "connect-src 'self' https://cdn.onesignal.com https://onesignal.com",
            "img-src 'self' https://cdn.onesignal.com https://onesignal.com data:",
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
