<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildProfileRequest;
use App\Models\ChildProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChildProfileController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Children/Index', [
            'children' => $request->user()->childProfiles()->latest()->get(),
            'limit' => 3,
        ]);
    }

    public function store(StoreChildProfileRequest $request): RedirectResponse
    {
        abort_if($request->user()->childProfiles()->count() >= 3, 422, 'Each account may have up to three child profiles.');

        $request->user()->childProfiles()->create($request->validated());

        return back()->with('success', 'Child profile created.');
    }

    public function update(StoreChildProfileRequest $request, ChildProfile $childProfile): RedirectResponse
    {
        abort_unless($childProfile->user_id === $request->user()->id, 403);
        $childProfile->update($request->validated());

        return back()->with('success', 'Child profile updated.');
    }

    public function destroy(Request $request, ChildProfile $childProfile): RedirectResponse
    {
        abort_unless($childProfile->user_id === $request->user()->id, 403);
        $childProfile->delete();

        return back()->with('success', 'Child profile removed.');
    }
}
