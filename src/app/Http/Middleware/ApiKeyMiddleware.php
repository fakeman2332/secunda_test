<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/*') && $request->header('X-Api-Key') != config('api.key')) {
            abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}
