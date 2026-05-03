<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('services.api.token');

        if (empty($expected)) {
            abort(500, 'API token not configured');
        }

        $provided = $request->bearerToken() ?? $request->header('X-Api-Token');

        if (!is_string($provided) || !hash_equals($expected, $provided)) {
            abort(401, 'Invalid or missing API token');
        }

        return $next($request);
    }
}
