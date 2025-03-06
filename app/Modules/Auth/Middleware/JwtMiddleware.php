<?php

namespace App\Modules\Auth\Middleware;

use App\Modules\Auth\JwtService;
use Closure;
use Exception;
use Illuminate\Http\Request;

class JWTMiddleware
{
    public function __construct(private JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $this->jwtService->verify($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
