<?php

namespace App\Modules\Auth\Middleware;

use App\Modules\Auth\ApiKey\ApiKeyRepository;
use Closure;
use Illuminate\Http\Request;

class AuthApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');
        $exists = app(ApiKeyRepository::class)->existsByRawValue($apiKey);

        if (validator([
            'api_key' => $apiKey
        ], [
            'api_key' => ['required']
        ])->fails() || ! $exists) {
            return response()->json(['success' => false], 403);
        }

        return $next($request);
    }
}
