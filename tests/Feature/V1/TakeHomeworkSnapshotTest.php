<?php

namespace Tests\Feature\V1;

use App\Events\HomeworkStarted;
use App\Listeners\TakeHomeworkSnapshot;
use App\Models\Assignment;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TakeHomeworkSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_triggered_by_homework_started_event()
    {
        Event::fake();
        $assignment = $this->mock(Assignment::class);

        HomeworkStarted::dispatch($assignment);

        Event::assertListening(
            HomeworkStarted::class,
            TakeHomeworkSnapshot::class
        );
    }
}
