<?php

namespace App\Http\Middleware;

use Closure;
use Livewire\Livewire;
use Illuminate\Support\Facades\Vite;

class AddContentSecurityPolicyHeaders
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
        Vite::useCspNonce();

        return $next($request)->withHeaders([
            'Content-Security-Policy' => "script-src 'nonce-" . Vite::cspNonce() . "'",
            'Content-Security-Policy' => "base-uri 'self'",
            'Content-Security-Policy' => "connect-src'self'",
            'Content-Security-Policy' => "default-src 'self'",
            'Content-Security-Policy' => "form-action 'self'",
            'Content-Security-Policy' => "img-src 'self'",
            'Content-Security-Policy' => "media-src 'self'",
            'Content-Security-Policy' => "object-src 'self'",
            //'Content-Security-Policy' => "script-src 'self'",
            //'Content-Security-Policy' => "style-src 'self'",

        ]);
    }
}
