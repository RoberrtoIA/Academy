<?php

namespace Tests\Feature\V1;

use App\Models\Execution;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishExecutionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    /** @test */
    public function it_finishes_an_execution()
    {
        $execution = Execution::factory()->create();

        $this->sanctumActingAsManager();

        $this->assertNull($execution->finished);

        $response = $this->get(route(
            'api.v1.executions.finish',
            ['execution' => $execution->id]
        ))
            ->assertOk()
            ->assertJsonFragment(['id' => $execution->id]);

        $data = $response->json('data');

        $this->assertNotNull($data['finished'] ?? null);
    }
}
