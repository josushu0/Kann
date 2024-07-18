<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = $request->query('rows', 20);
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'asc');
        $roles = Role::orderBy($sort, $order)->paginate($rows);

        return Inertia::render('Roles/List', [
            'roles' => $roles,
            'order' => $order,
            'sort' => $sort,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'addPermissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->givePermissionTo($validated['addPermissions']);

        return to_route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::findById($id);

        return Inertia::render('Roles/Edit', [
            'role' => $roles,
            'rolePermissions' => $roles->permissions,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'addPermissions' => 'required|array',
            'removePermissions' => 'required|array',
        ]);

        $role = Role::findById($id);
        $role->givePermissionTo($validated['addPermissions']);
        $role->revokePermissionTo($validated['removePermissions']);

        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::findById($id)->delete();

        return back();
    }
}
