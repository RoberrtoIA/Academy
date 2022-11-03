<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserService
{
    public function createUser(FormRequest $request): User
    {
        $data = $request->validated();
        $data['roles'] = $request->roles;
        /** @var User */
        $user = null;
        DB::transaction(function () use ($data, &$user) {
            $roles = $data['roles'];
            /** @var User */
            $user = User::query()->create($data);

            if ($roles) {
                $rolesId = app()->make(\App\Services\UserRoleService::class)
                    ->getRoleIdListFromNames($roles);
                $user->roles()->sync($rolesId);
            }
        });

        return $user;
    }
}
