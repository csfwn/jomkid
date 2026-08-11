<?php

namespace App\Http\Controllers;

use App\Models\LearningModule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Dashboard', [
            'children' => $user->childProfiles()->latest()->get(),
            'modules' => LearningModule::query()->where('status', 'published')->withCount(['lessons' => fn ($query) => $query->where('is_published', true)])->orderBy('sort_order')->get(),
            'subscription' => $user->subscriptions()->latest()->first(),
        ]);
    }
}
