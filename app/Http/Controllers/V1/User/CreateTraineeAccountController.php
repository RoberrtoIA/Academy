<?php

namespace App\Http\Controllers\V1\User;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Resources\UserResource;

class CreateTraineeAccountController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        StoreTraineeRequest $request,
        UserService $service
    ) {
        $request->merge(['roles' => ['trainee']]);

        return new UserResource($service->createUser($request)->load('roles'));
    }
}
