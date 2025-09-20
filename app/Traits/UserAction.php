<?php

namespace App\Traits;

use App\Enums\TokenAbilityEnum;

trait UserAction
{
    // ================================================	New Code ================================================
    public function tokenWithBearer(): string
    {
        /** @var User $this */
        $accessToken = $this->createToken('access_token', [TokenAbilityEnum::ACCESS_API->value], (int) config('sanctum.expiration'));

        return 'Bearer '.$accessToken->plainTextToken;
    }

    public function refreshTokenWithBearer(): string
    {
        $refreshToken = $this->createToken('refresh_token', [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value], (int) config('sanctum.refresh_expiration'));

        return 'Bearer '.$refreshToken->plainTextToken;
    }

    public function logout(bool $logoutFromAllDevice = false): bool
    {
        $this->update([
            'fcm_token' => null,
        ]);
        if ($logoutFromAllDevice) {
            $this->tokens()->delete();
        } else {
            $this->currentAccessToken()->delete();
        }

        return true;
    }
}
