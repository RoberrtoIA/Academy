<?php

namespace Tests\Feature\V1;

use App\Models\EvaluationCriteria;
use App\Models\Grading;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaveEvaluationCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_creates_a_new_grading()
    {
        $data = Grading::factory()->for(
            EvaluationCriteria::factory(),
            'gradable'
        )->make()->toArray();

        $this->sanctumActingAsTrainer();

        $this->assertDatabaseCount('gradings', 0);

        $this->put(route('api.v1.save-evaluation-criteria'), $data)
            ->assertCreated();

        $this->assertDatabaseCount('gradings', 1);
    }
}
