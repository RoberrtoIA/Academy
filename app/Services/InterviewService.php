<?php

namespace App\Services;

use App\Events\InterviewStarted;
use App\Models\Assignment;
use Carbon\Carbon;

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
}
