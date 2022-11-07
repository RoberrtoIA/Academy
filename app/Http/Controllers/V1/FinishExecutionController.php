<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutionResource;
use App\Models\Execution;
use App\Services\ExecutionService;
use Illuminate\Http\Request;

class FinishExecutionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Execution $execution, ExecutionService $service)
    {
        return new ExecutionResource($service->finishExecution($execution));
    }
}
