<?php

namespace App\Modules\Auth\Middleware;

use App\Modules\Auth\JwtService;
use Closure;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated as RedirectIfAuthenticatedTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated extends RedirectIfAuthenticatedTemplate
{
    public function __construct(private JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                return response()->json(['token' => $this->jwtService->generateToken($user)], 201);
            }
        }

        return $next($request);
    }
}
