<?php

namespace Tests\Feature\V1;

use App\Models\Assignment;
use App\Events\HomeworkFinished;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateHomeworkGrade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateHomeworkGradeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_triggered_by_homework_finished_event()
    {
        Event::fake();
        $assignment = $this->mock(Assignment::class);

        HomeworkFinished::dispatch($assignment);

        Event::assertListening(
            HomeworkFinished::class,
            UpdateHomeworkGrade::class
        );
    }
}
