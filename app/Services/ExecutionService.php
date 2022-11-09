<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Execution;
use App\Events\ExecutionFinished;
use App\Http\Resources\ProgramResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ExecutionService
{
    public function createExecution(FormRequest $request): Execution
    {
        $data = $request->validated();

        return Execution::create($data);
    }

    public function updateExecution(
        FormRequest $request,
        Execution $execution
    ): Execution {
        $data = $request->validated();
        $execution->update($data);

        return $execution;
    }

    public function finishExecution(Execution $execution): Execution
    {
        $execution->finished = Carbon::now();
        $execution->save();

        ExecutionFinished::dispatch($execution);

        return $execution;
    }

    public function takeProgramSnapshot(Execution $execution): Execution
    {
        $execution->program_execution_content = (new ProgramResource(
            $execution->program()->with('modules.topics')->first()
        ))
            ->resolve();
        $execution->save();
        return $execution;
    }

    public function assignTrainer(Execution $execution, User $user)
    {
        $this->validateTrainerRole($user);

        $execution->trainers()->attach($user);

        return $execution;
    }

    public function enrollTrainee(Execution $execution, User $user)
    {
        $this->validateTraineeRole($user);

        $execution->enrollments()->attach($user);

        return $execution;
    }

    /**
     * @throws Illuminate\Validation\ValidationException
     */
    protected function validateTrainerRole(User $user): void
    {
        $this->validateRole($user, 'trainer');
    }

    /**
     * @throws Illuminate\Validation\ValidationException
     */
    protected function validateTraineeRole(User $user): void
    {
        $this->validateRole($user, 'trainee');
    }

    /**
     * @throws Illuminate\Validation\ValidationException
     */
    protected function validateRole(User $user, string $role): void
    {
        Validator::make([],[])->after( function ($validator) use ($user, $role) {
            if (!$user->roles()->pluck('name')->contains($role)) {
                $validator->errors()
                    ->add($role, "The user is not a $role.");
            }
        })
            ->validate();
    }
}
