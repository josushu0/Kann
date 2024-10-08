<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Column;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $team = $request->user()->currentTeam;

        return Inertia::render('Projects/List', [
            'projects' => $team->projects,
            'canCreateProject' => Gate::allows('create', Project::class),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Project::class);

        return Inertia::render('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Gate::authorize('create', Project::class);

        $validated = $request->validated();
        $request->user()->currentTeam->projects()->create($validated);

        return to_route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        Gate::authorize('view', $project);

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'data' => $project->columns()->with(['tasks' => function (Builder $query) {
                $query->orderBy('position');
            }])->orderBy('position')->get(),
            'teamMembers' => $project->team->allUsers(),
            'canUpdateColumn' => Gate::allows('update', $project),
            'canDeleteColumn' => Gate::allows('delete', $project),
            'canCreateColumn' => Gate::allows('create', Column::class),
            'canCreateTask' => Gate::allows('create', Task::class),
            'canDeleteTask' => Gate::allows('delete'),
            'isAdmin' => auth()->user()->hasTeamRole(auth()->user()->currentTeam, 'admin'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        Gate::authorize('view', $project);

        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'canUpdateProject' => Gate::allows('update', $project),
            'canDeleteProject' => Gate::allows('delete', $project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validated = $request->validated();
        $project->update($validated);

        return to_route('projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);
        $project->delete();

        return to_route('projects.index');
    }
}
