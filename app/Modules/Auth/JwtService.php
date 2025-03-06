<?php

namespace App\Modules\Auth;

use App\Modules\User\User;
use Illuminate\Http\Request;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\AuthenticationException;
use stdClass;

class JwtService
{
    public function generateToken(User $user)
    {
        return JWT::encode([
            'iss' => config('app.url'),
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ], config('auth.jwt.signing_key'), config('auth.jwt.algorithm'));
    }

    public function getRawJWT(Request $request)
    {
        if(! $request->hasHeader('Authorization')) {
            throw new AuthenticationException('Authorization header is required');
        }

        $jwt = str_replace('Bearer ', '', $request->header('Authorization'));
        if (!$jwt) {
            throw new AuthenticationException('Token not found');
        }

        return $jwt;
    }

    public function decodeRaw(string $jwt)
    {
        try {
            $headers = new stdClass();
            $token = JWT::decode($jwt, new Key(config('auth.jwt.signature_key'), config('auth.jwt.algorithm')), $headers);
        } catch(Exception $e) {
            throw new AuthenticationException('Unauthorized');
        }

        return $token;
    }

    public function verify(Request $request)
    {
        $jwt = $this->getRawJWT($request);
        $token = $this->decodeRaw($jwt);

        return $token;
    }
}
