<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class UserRoleService
{

    /**
     * Get flat array of all the abilities from user roles
     */
    public function getFlattenAbilities(User $user): array
    {
        $roles = $user->roles()->with('abilities')->get();

        $abilities = collect();
        foreach ($roles as $role) {
            $abilities = $abilities->merge($role->abilities->pluck('name'));
        }

        return $abilities->all();
    }

    public function getRoleIdListFromNames(array $roleNames): array
    {
        return Role::query()->whereIn('name', $roleNames)->pluck('id')->all();
    }

    public function syncUserRoles(User $user, ?array $roleNames): static
    {
        if ($roleNames) {
            $rolesId = $this->getRoleIdListFromNames($roleNames);
            $user->roles()->sync($rolesId);
        }

        return $this;
    }
}
