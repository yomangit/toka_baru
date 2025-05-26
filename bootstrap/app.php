<?php

use Illuminate\Http\Request;
use Spatie\Csp\AddCspHeaders;
use App\Http\Middleware\setLocale;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\AuthenticateSession;
use App\Http\Middleware\AddContentSecurityPolicyHeaders;

return Application::configure(basePath: dirname(__DIR__))->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->web(append: [
            setLocale::class,
            // AddCspHeaders::class,
          AddContentSecurityPolicyHeaders::class,
        ]);
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'auth.session' => AuthenticateSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();
$app->usePublicPath(base_path('public_html'));
