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
    public function it_can_have_questions() {
        $question = Question::factory()->create();

        $grading = Grading::factory([
            'gradable_type' => $question->getMorphClass(),
            'gradable_id'   => $question->getKey(),
        ])->create();
        $this->assertInstanceOf(Question::class, $grading->gradable);
    }

    /** @test */
    public function it_can_have_evaluation_criterias() {
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
        Grading::factory()->count($count)->create();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.gradings.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_a_grading()
    {
        $grading = Grading::factory()->create()->load('gradable')->makeHidden(['gradable_id', 'gradable_type']);

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.gradings.show', ['grading' => $grading->id]))
            ->assertOk()
            ->assertJsonFragment([
                'data' => $grading->toArray()
            ]);
    }

    /** @test */
    public function it_creates_a_new_grading()
    {
        $data = Grading::factory()->make()->toArray();

        $this->sanctumActingAsDeveloper();

        $this->assertDatabaseCount('gradings', 0);

        $this->put(route('api.v1.gradings.upsert'), $data)
            ->assertCreated();

        $this->assertDatabaseCount('gradings', 1);
    }

    /** @test */
    public function it_updates_a_grading()
    {
        $grading = Grading::factory()->create();
        $data = [
            'comments' => 'comments changed',
            'grade' => 'grade chandes',
            'gradable_id' => $grading->gradable->getKey(),
            'gradable_type' => $grading->gradable->getMorphClass()
        ];

        $expectation = collect($grading->toArray())->merge($data)->all();
        unset($expectation["gradable_id"]);
        unset($expectation["gradable_type"]);

        $this->sanctumActingAsDeveloper();

        $this->put(route('api.v1.gradings.upsert'), $data)
            ->assertOk()
            ->assertJsonFragment($expectation);
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
