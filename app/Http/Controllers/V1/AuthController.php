<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        if (!$user || !Hash::check($attributes['password'], $user->password))
        {
            $response = ['message' => 'Invalid Credentials'];
            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken('myapptoken', /* $user->roles()->abilities->toArray() */[])->plainTextToken;

        $user->token = $token;
        return response(['data' => new UserResource($user)]);
    }
}
