<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\Request;

if (! function_exists('globalPerPage')) {
    function globalPerPage(?Request $request = null)
    {
        $defaultPerPage = 10;

        if (! $request) {
            return $defaultPerPage;
        }
        // accept per_page and perPage as query string
        $perPage = $request->query('perPage', $request->query('per_page', $defaultPerPage));

        $perPage = $perPage > 30 ? 30 : $perPage;

        return $perPage;
    }
}

if (! function_exists('authUser')) {
    function authUser(): ?User
    {
        if (auth('sanctum')->check()) {
            return auth('sanctum')->user();
        }

        return null;
    }
}
