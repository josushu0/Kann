<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('view', auth()->user());

        $sort = $request->query('sortColumn', 'id');
        $order = $request->query('sortOrder', 'asc');
        $rows = $request->query('rowCount', 20);
        $users = User::orderBy($sort, $order)->paginate($rows);

        return Inertia::render('Users/List', [
            'users' => $users,
            'sort' => [
                'id' => $sort,
                'order' => $order,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', auth()->user());

        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateNewUser $action)
    {
        Gate::authorize('create', auth()->user());

        $action->create($request->all());

        return to_route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', auth()->user());

        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, UpdateUserProfileInformation $action)
    {
        Gate::authorize('update', auth()->user());

        $action->update($user, $request->all());

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', auth()->user());

        $user->delete();

        return back();
    }
}
