<?php

namespace App\Http\Middleware;

use App\Models\BotIdentity;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolverBotUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $externalId = $request->header('X-Bot-User-Id');
        $provider = $request->header('X-Bot-Provider', 'telegram');

        if (!is_string($externalId) || $externalId === '') {
            abort(403, 'Unknown bot user');
        }

        $identity = BotIdentity::where('provider', $provider)
            ->where('external_id', $externalId)
            ->with('user')
            ->first();

        if ($identity === null || $identity->user === null) {
            abort(403, 'Unknown bot user');
        }

        auth()->login($identity->user);

        return $next($request);
    }
}
