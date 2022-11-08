<?php

namespace Tests\Feature\V1;

use App\Models\EvaluationCriteria;
use App\Models\Grading;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_have_questions()
    {
        $question = Question::factory()->create();

        $grading = Grading::factory([
            'gradable_type' => $question->getMorphClass(),
            'gradable_id'   => $question->getKey(),
        ])->create();
        $this->assertInstanceOf(Question::class, $grading->gradable);
    }

    /** @test */
    public function it_can_have_evaluation_criterias()
    {
        $evaluation = EvaluationCriteria::factory()->create();

        $grading = Grading::factory([
            'gradable_type' => $evaluation->getMorphClass(),
            'gradable_id'   => $evaluation->getKey(),
        ])->create();
        $this->assertInstanceOf(EvaluationCriteria::class, $grading->gradable);
    }

    /** @test */
    public function it_can_list_gradings()
    {
        $count = 5;
        Grading::factory($count)->create()->toArray();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.gradings.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_a_grading()
    {
        $grading =  Grading::factory()->create()->load('gradable');

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.gradings.show', ['grading' => $grading->id]))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $grading->id,
                'created_at' => $grading->created_at
            ]);
    }

    /** @test */
    public function it_soft_deletes_a_grading()
    {
        $grading = Grading::factory()->create();

        $this->sanctumActingAsDeveloper();

        $this->delete(route(
            'api.v1.gradings.destroy',
            ['grading' => $grading->id]
        ))
            ->assertOk();

        $this->assertSoftDeleted('gradings', $grading->toArray());
    }
}
