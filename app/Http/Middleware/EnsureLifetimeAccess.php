<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLifetimeAccess
{
    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->access_status !== 'active') {
            return redirect()->route('checkout.index')->withErrors([
                'payment' => 'Akses JomKid diperlukan untuk menggunakan fungsi ini.',
            ]);
        }

        return $next($request);
    }
}
