<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Assignment;
use App\Events\InterviewStarted;
use App\Http\Resources\ModuleResource;

class InterviewService
{
    public function startEvaluation(Assignment $assignment): Assignment
    {
        $assignment->interview_start_at = Carbon::now()->toDateTimeString();
        $assignment->save();

        InterviewStarted::dispatch($assignment);

        return $assignment;
    }

    public function finishEvaluation(Assignment $assignment): Assignment
    {
        $assignment->interview_finish_at = Carbon::now()->toDateTimeString();;
        $assignment->save();

        return $assignment;
    }

    public function takeSnapshot(Assignment $assignment)
    {
        $assignment->interview_snapshot = (new ModuleResource(
            $assignment->module()->with('topics.questions')->first()
        ))
            ->resolve();
        $assignment->save();
        return $assignment;
    }
}
