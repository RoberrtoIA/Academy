<?php

namespace Tests\Feature\V1;

use App\Models\Grading;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaveQuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_creates_a_new_question_grading()
    {
        $data = Grading::factory()->for(
            Question::factory(),
            'gradable'
        )->make()->toArray();

        $this->sanctumActingAsTrainer();

        $this->assertDatabaseCount('gradings', 0);

        $this->put(route('api.v1.save-question'), $data)
            ->assertCreated();

        $this->assertDatabaseCount('gradings', 1);
    }
}
