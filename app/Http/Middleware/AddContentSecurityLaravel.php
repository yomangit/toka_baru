<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddContentSecurityLaravel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)->withHeaders([
            'Content-Security-Policy' => "script-src 'nonce-wZtTiEPFKU1j4o6FxDIKdPSI0US44syydQO0Rw3D' 'nonce-ItEjHTKGMu1grZ1xRET3CE0R4oT7tXbuo6YQzkQk' 'nonce-pEg4krvr3gBbgB71HVgrMeRi6P4RbxTVTo3EbICL' 'nonce-pf0MgDWjb0LdljigBfyDpq3USjG58lv7IahOe3q2' 'nonce-rbzXQAORu0hJV6FCR9qr9Px9lBSDtIvQXIdCh1S5'",
        ]);
    }
}
