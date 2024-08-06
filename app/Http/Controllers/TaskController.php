<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Task::class);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'due_date' => 'nullable|date',
            'column_id' => 'required|exists:columns,id',
            'assigned' => 'nullable|exists:users,id',
        ]);

        Task::create($validated);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'due_date' => 'nullable|date',
            'column_id' => 'required|exists:columns,id',
            'assigned' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->back();
    }

    public function move(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $validated = $request->validate([
            'position' => 'required|numeric',
            'column_id' => 'sometimes|required|exists:columns,id',
        ]);

        $task->position = $validated['position'];
        $task->column_id = $validated['column_id'] ?? $task->column_id;
        $task->save();

        return redirect()->back();
    }
}
