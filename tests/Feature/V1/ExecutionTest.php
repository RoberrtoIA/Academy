<?php

namespace Tests\Feature\V1;

use App\Models\Execution;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExecutionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    /** @test */
    public function it_can_list_executions()
    {
        $count = 3;
        Execution::factory()->count($count)->create();

        $this->sanctumActingAsManager();

        $this->get(route('api.v1.executions.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_an_execution()
    {
        $execution = Execution::factory()->create();

        $this->sanctumActingAsManager();

        $this->get(route(
            'api.v1.executions.show',
            ['execution' => $execution->id]
        ))
            ->assertOk()
            ->assertJsonFragment(['id' => $execution->id]);
    }

    /** @test */
    public function it_creates_a_new_execution()
    {
        $data = collect(Execution::factory()->make()->toArray())
            ->only(['program_id', 'start_date', 'end_date'])
            ->all();

        $this->sanctumActingAsManager();

        $this->assertDatabaseMissing('executions', $data);

        $this->post(route('api.v1.executions.store'), $data)
            ->assertCreated()
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('executions', $data);
    }
}
