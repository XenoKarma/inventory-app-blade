<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response('This action is unauthorized.', 403);
        }

        return $next($request);
    }
}
