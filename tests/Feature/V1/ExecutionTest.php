<?php

namespace Tests\Feature\V1;

use App\Models\Execution;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExecutionTest extends TestCase
{
    use RefreshDatabase;

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
}
