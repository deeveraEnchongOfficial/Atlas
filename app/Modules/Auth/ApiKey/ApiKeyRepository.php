<?php

namespace App\Modules\Auth\ApiKey;

class ApiKeyRepository
{
    public function existsByRawValue(string $value): bool
    {
        $hash = hash('sha256', $value);
        return ApiKey::where('hash', $hash)->exists();
    }

    public function findByValue(string $value): ?ApiKey
    {
        $hash = hash('sha256', $value);
        return ApiKey::where('hash', $hash)->first();
    }
}
