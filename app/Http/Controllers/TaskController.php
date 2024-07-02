<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function move(Request $request, Task $task): RedirectResponse
    {
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
