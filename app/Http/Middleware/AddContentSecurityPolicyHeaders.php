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
        // Buat nonce dan simpan di container (bisa dipakai di Blade)
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp_nonce', $nonce);

        // Pakai nonce untuk Vite juga
        Vite::useCspNonce($nonce);

        // CSP Header
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' https://cdn.onesignal.com https://onesignal.com https://cdn.ckeditor.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' 'unsafe-eval' https://cdn.jsdelivr.net https://fonts.gstatic.com",
            "connect-src 'self' 'unsafe-eval' https://cdn.onesignal.com https://onesignal.com",
            "img-src 'self''unsafe-eval' https://cdn.onesignal.com https://onesignal.com data:",
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
