<?php

namespace App\Services;

use App\Events\HomeworkStarted;
use App\Http\Requests\HomeworkSolutionRequest;
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

        return $assignment;
    }

    public function uploadHomeworkSolution(Assignment $assignment, HomeworkSolutionRequest $request): Assignment
    {
        $attributes = $request->validated();

        $assignment->homework_solution = $attributes['homework_solution'];

        $assignment->save();

        return $assignment;
    }
}
