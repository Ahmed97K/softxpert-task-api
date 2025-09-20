<?php

namespace App\Http\Controllers;

use App\Enums\ResponseEnum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->firstOrFail();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return response()->json(
                [
                    'message' => __('auth.failed'),
                ],
                ResponseEnum::HTTP_UNAUTHORIZED,
            );
        }

        return $this->ok(__('auth.logged_in_successfully'), LoginResource::make($user));
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        if ($request->bearerToken()) {
            $user = authUser();
            if ($user) {
                $user->logout($request->boolean('logout_from_all_device', false));
            }
        }

        return $this->ok(__('auth.you_are_logged_out'));
    }
}
