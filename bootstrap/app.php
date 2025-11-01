<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => function (Request $request, \Closure $next) {
                // cek apakah user login di salah satu guard
                if (!Auth::guard('web')->check()) {
                    abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
                }

                return $next($request);
            },

            'auth:peminjam' => function (Request $request, \Closure $next) {
                // cek apakah user login di salah satu guard
                if (!Auth::guard('peminjam')->check()) {
                    abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
                }

                return $next($request);
            },
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
