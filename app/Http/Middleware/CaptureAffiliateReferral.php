<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CaptureAffiliateReferral
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $code = $request->query('ref');

        if (is_string($code) && $code !== '') {
            $affiliate = User::query()
                ->whereRaw('upper(affiliate_code) = ?', [Str::upper($code)])
                ->where('affiliate_active', true)
                ->whereIn('role', ['affiliate', 'admin'])
                ->first();

            if ($affiliate) {
                $request->session()->put('affiliate_user_id', $affiliate->id);
            }
        }

        return $next($request);
    }
}
