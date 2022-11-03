<?php

namespace App\Http\Controllers\V1\User;

use Illuminate\Http\Request;
use App\Services\CreateUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Resources\UserResource;

class CreateTraineeAccount extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        StoreTraineeRequest $request,
        CreateUserService $service
    ) {
        $request->merge(['roles' => ['trainee']]);
        $trainee = $service->createUser($request);

        return new UserResource($trainee->load('roles'));
    }
}
