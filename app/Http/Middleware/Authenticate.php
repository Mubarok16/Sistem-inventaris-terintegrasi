<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        if (!in_array($request->user()->hak_akses, $roles)) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}
