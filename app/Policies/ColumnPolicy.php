<?php

namespace App\Policies;

use App\Models\Column;
use App\Models\User;

class ColumnPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Column $column): bool
    {
        return $user->belongsToTeam($column->project->team);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->hasTeamPermission($user->currentTeam, 'create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Column $column): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->hasTeamPermission($column->project->team, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Column $column): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->hasTeamPermission($column->project->team, 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Column $column): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->hasTeamPermission($column->project->team, 'delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Column $column): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->hasTeamPermission($column->project->team, 'delete');
    }
}
