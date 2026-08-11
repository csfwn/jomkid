<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AffiliateDashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $query = AffiliateCommission::query()->where('affiliate_user_id', $request->user()->id);

        return Inertia::render('Affiliate/Dashboard', [
            'affiliateCode' => $request->user()->affiliate_code,
            'summary' => [
                'pending_sen' => (clone $query)->where('status', 'pending')->sum('amount_sen'),
                'available_sen' => (clone $query)->where('status', 'available')->sum('amount_sen'),
                'paid_sen' => (clone $query)->where('status', 'paid')->sum('amount_sen'),
                'sales' => (clone $query)->count(),
            ],
            'commissions' => $query->latest()->limit(20)->get(),
        ]);
    }
}
