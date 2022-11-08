<?php

namespace Tests\Feature\V1;

use App\Models\Execution;
use App\Events\ExecutionFinished;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Listeners\TakeProgramExecutionContentSnapshot;

class TakeProgramExecutionContentSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_triggered_by_execution_finished_event()
    {
        Event::fake();
        $execution = $this->mock(Execution::class);

        ExecutionFinished::dispatch($execution);

        Event::assertListening(
            ExecutionFinished::class,
            TakeProgramExecutionContentSnapshot::class
        );
    }
}
