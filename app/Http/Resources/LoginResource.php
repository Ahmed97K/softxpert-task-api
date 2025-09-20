<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->tokenWithBearer(),
            'refresh_token' => $this->refreshTokenWithBearer(),
            'token_expired_at' => Carbon::now()->addMinutes((int) config('sanctum.expiration')),
        ];
    }
}
