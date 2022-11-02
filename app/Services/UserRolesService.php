<?php

namespace App\Services;

use App\Models\Role;

class UserRolesService
{

    public function roles($roles): array
    {
        $attributes = array();

        foreach ($roles as $role) {
            $attributes[] = $role['name'];
        }

        return $attributes;
    }
}
