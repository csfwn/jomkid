<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use App\Models\ChildProfile;
use App\Models\LearningModule;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'metrics' => [
                'users' => User::count(),
                'children' => ChildProfile::count(),
                'modules' => LearningModule::count(),
                'active_access' => User::where('access_status', 'active')->count(),
                'pending_commission_sen' => AffiliateCommission::where('status', 'pending')->sum('amount_sen'),
            ],
            'recentUsers' => User::latest()->limit(8)->get(['id', 'name', 'email', 'role', 'created_at']),
        ]);
    }
}
