<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TaskList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return Inertia::render('Projects/List', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
        ]);

        Project::create($validated);

        return to_route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::select(['id', 'name'])->find($id);
        $lists = TaskList::where('project_id', $id)->orderBy('position')->get();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'lists' => $lists,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Projects/Edit', [
            'project' => Project::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
        ]);

        Project::find($id)->update($validated);

        return to_route('projects.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Project::find($id)->delete();

        return back();
    }
}
