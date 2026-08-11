<?php

namespace App\Http\Controllers;

use App\Models\LearningModule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LearnController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Learn/Index', [
            'children' => $request->user()->childProfiles()->get(),
            'modules' => LearningModule::query()->where('status', 'published')->with(['lessons' => fn ($query) => $query->where('is_published', true)])->orderBy('sort_order')->get(),
        ]);
    }
}
