<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Tasks/Index', [

            'tasks' => Task::with('user:id,name')->latest()->get(),

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

            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
            'exp' => 'nullable|date',
            'skill_id' => 'nullable|exists:skills,id',
            'message' => 'required|string|max:255',

        ]);

        $request->user()->tasks()->create($validated);
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse

    {
        Gate::authorize('update', $task);


        $validated = $request->validate([

            'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'completed' => 'nullable|boolean',
        'exp' => 'nullable|date',
        'skill_id' => 'nullable|exists:skills,id',
        'message' => 'required|string|max:255',

        ]);
        $task->update($validated);
        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);
        $task->delete();
        return redirect(route('tasks.index'));
    }
}
