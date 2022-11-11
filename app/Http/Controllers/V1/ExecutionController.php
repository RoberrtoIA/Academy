<?php

namespace App\Http\Controllers\V1;

use App\Models\Execution;
use App\Services\ExecutionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutionResource;
use App\Http\Requests\StoreExecutionRequest;
use App\Http\Requests\UpdateExecutionRequest;
use App\Models\User;

class ExecutionController extends Controller
{
    protected ?User $user;

    public function __construct() {
        $this->user = request()->user();
    }

    public function index()
    {
        $executions = Execution::query();

        if ($this->user->tokenCan('see_program_content_details')) {
            $executions = $this->user->myExecutionsAsTrainer();
        }

        return ExecutionResource::collection(
            $executions->with('program')->paginate(100)
        );
    }

    public function store(
        StoreExecutionRequest $request,
        ExecutionService $service
    ) {
        return new ExecutionResource($service->createExecution($request));
    }

    public function show(Execution $execution)
    {
        if ($this->user->tokenCan('see_program_content_details')) {
            $execution->trainers()->findOrFail($this->user->id);
        }

        if (
            $this->user->tokenCan('see_program_content_details')
        ) {
            $execution->load([
                'trainers',
                'program.modules.evaluation_criteria',
                'program.modules.topics.questions',
            ]);
        }

        if ($this->user->tokenCan('see_program_content')) {
            $execution->load([
                'program.modules.topics',
                'assignments' => function ($query) {
                    $query->where('user_id', $this->user->id)
                        ->with('gradings');
                }
            ]);
        }

        return new ExecutionResource($execution);
    }

    public function update(
        UpdateExecutionRequest $request,
        Execution $execution,
        ExecutionService $service
    ) {
        return new ExecutionResource(
            $service->updateExecution($request, $execution)
        );
    }

    public function destroy(Execution $execution)
    {
        $execution->delete();

        return response(['message' => 'Execution was deleted.']);
    }
}
