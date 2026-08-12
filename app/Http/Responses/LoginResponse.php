<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false]);
        }

        $destination = $request->user()?->role === User::ROLE_ADMIN
            ? route('admin.dashboard', absolute: false)
            : route('dashboard', absolute: false);

        return new RedirectResponse($request->session()->pull('url.intended', $destination));
    }
}
