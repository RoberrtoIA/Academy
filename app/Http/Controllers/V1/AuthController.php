<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserRolesService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(protected UserRolesService $userRolesService)
    {
    }

    public function login(LoginUserRequest $request)
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            $response = ['message' => 'Invalid Credentials'];

            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken('myapptoken', $this->userRolesService->roles($user->roles))->plainTextToken;

        $user->token = $token;

        return response(['data' => new UserResource($user)]);
    }

    public function ability()
    {
        $user = auth('sanctum')->user();

        return RoleResource::collection($user->roles);
    }
}
