<?php

namespace App\Services;

use App\Models\User;

class UserRolesService
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
}
