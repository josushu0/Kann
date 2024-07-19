<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::find($request->project)->taskLists()->create($validated);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|numeric',
        ]);

        TaskList::find($id)->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TaskList::find($id)->delete();

        return back();
    }
}
