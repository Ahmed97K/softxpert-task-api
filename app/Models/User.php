<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserAction;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Laravel\Sanctum\NewAccessToken;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles, UserAction;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function createToken(string $name, array $abilities = ['*'], $expiresAt = null)
    {
        $expiration = (int) config('sanctum.expiration');
        $token      = $this->tokens()->create([
            'name'       => $name,
            'token'      => hash('sha256', $plainTextToken = Str::random(240)),
            'abilities'  => $abilities,
            'expires_at' => Carbon::now()->addMinutes((int) $expiresAt ?? config('sanctum.expiration')),
        ]);

        return new NewAccessToken($token, $token->id.'|'.$plainTextToken);
    }
}
