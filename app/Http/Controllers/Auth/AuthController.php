<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Auth\JwtService;
use App\Modules\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $this->jwtService->generateToken($user);

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getUser(Request $request)
    {
        $token = $request->header('Authorization');

        if (! $token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $decoded = $this->jwtService->verify($request);

        if (! $decoded) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $user = User::find($decoded->sub);

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }
}
