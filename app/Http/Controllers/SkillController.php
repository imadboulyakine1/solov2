<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Skills/Index', [

            'skills' => Skill::with('user:id,name')->latest()->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse

    {
        $validated = $request->validate([

            'message' => 'required|string|max:255',

        ]);
        $request->user()->skills()->create($validated);
        return redirect(route('skills.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill): RedirectResponse

    {
        Gate::authorize('update', $skill);


        $validated = $request->validate([

            'message' => 'required|string|max:255',

        ]);
        $skill->update($validated);
        return redirect(route('skills.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        Gate::authorize('delete', $skill);
        $skill->delete();
        return redirect(route('skills.index'));
    }
}
