<?php

namespace Tests\Feature\V1;

use App\Models\Assignment;
use App\Events\InterviewStarted;
use Illuminate\Support\Facades\Event;
use App\Listeners\TakeInterviewSnapshot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TakeInterviewSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_triggered_by_interview_started_event()
    {
        Event::fake();
        $assignment = $this->mock(Assignment::class);

        InterviewStarted::dispatch($assignment);

        Event::assertListening(
            InterviewStarted::class,
            TakeInterviewSnapshot::class
        );
    }
}
