<?php

namespace App\Modules\Auth\ApiKey\Actions;

use App\Modules\Auth\ApiKey\ApiKey;
use App\Modules\User\User;
use Illuminate\Support\Str;

class GenerateApiKey
{
    private const API_KEY_LENGTH = 32;
    public function execute(User $user)
    {

        $apiKey = Str::random(self::API_KEY_LENGTH);
        $mask = substr($apiKey, 0, 7) . str_repeat('*', strlen($apiKey) - 7);

        return $user->apiKeys()->save(
            (new ApiKey())
            ->forceFill([
                'name' => 'API Key ' . now()->toIso8601String(),
                'mask' => $mask,
                'value' => $apiKey,
                'expires_at' => now()->addYear(),
                'user_id' => $user->getKey()
            ])
        );
    }
}
