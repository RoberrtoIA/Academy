<?php

namespace Tests\Feature\V1;

use App\Models\Assignment;
use App\Events\InterviewFinished;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateInterviewGrade;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInterviewGradeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_is_triggered_by_interview_finished_event()
    {
        Event::fake();
        $assignment = $this->mock(Assignment::class);

        InterviewFinished::dispatch($assignment);

        Event::assertListening(
            InterviewFinished::class,
            UpdateInterviewGrade::class
        );
    }
}
