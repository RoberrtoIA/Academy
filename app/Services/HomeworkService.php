<?php

namespace App\Services;

use App\Events\HomeworkStarted;
use App\Http\Requests\HomeworkSolutionRequest;
use App\Http\Resources\ModuleResource;
use App\Models\Assignment;
use Carbon\Carbon;

class HomeworkService
{
    public function startHomework(Assignment $assignment): Assignment
    {
        $assignment->homework_start_at = Carbon::now()->toDateTimeString();
        $assignment->save();

        HomeworkStarted::dispatch($assignment);

        return $assignment;
    }

    public function finishHomework(Assignment $assignment): Assignment
    {
        $assignment->homework_finish_at = Carbon::now()->toDateTimeString();;
        $assignment->save();

        HomeworkFinished::dispatch($assignment);

        return $assignment;
    }

    public function uploadHomeworkSolution(Assignment $assignment, HomeworkSolutionRequest $request): Assignment
    {
        $attributes = $request->validated();

        $assignment->homework_solution = $attributes['homework_solution'];

        $assignment->save();

        return $assignment;
    }

    public function takeSnapshot(Assignment $assignment)
    {
        $assignment->homework_snapshot = (new ModuleResource(
            $assignment->module()->with('evaluation_criteria')->first()
        ))
            ->resolve();
        $assignment->save();
        return $assignment;
    }
}
