<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ColumnController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Column::class);

        $request->validate([
            'name' => 'required|max:255',
            'project_id' => 'required',
        ]);

        $project = Project::find($request->project_id);
        $project->columns()->create([
            'name' => $request->name,
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Column $column): RedirectResponse
    {
        Gate::authorize('update', $column);

        $request->validate([
            'name' => 'required',
        ]);

        $column->name = $request->name;
        $column->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        Gate::authorize('delete', $column);

        $column->delete();

        return redirect()->back();
    }

    public function move(Request $request, Column $column): RedirectResponse
    {
        Gate::authorize('update', $column);

        $request->validate([
            'position' => 'required|numeric',
        ]);

        $column->position = $request->position;
        $column->save();

        return redirect()->back();
    }
}
