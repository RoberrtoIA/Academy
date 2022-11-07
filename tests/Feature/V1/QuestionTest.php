<?php

namespace Tests\Feature\V1;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_list_questions()
    {
        $count = 5;
        Question::factory()->count($count)->create();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.questions.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_a_question()
    {
        $question = Question::factory()->create()->load('topic');

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.questions.show', ['question' => $question->id]))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $question->id,
                    'question' => $question->question,
                    'created_at' => $question->created_at,
                    'updated_at' => $question->updated_at,
                    'topic' => [
                        'id' => $question->topic->id,
                        'title' => $question->topic->title,
                        'description' => $question->topic->description,
                        'content' => $question->topic->content,
                        'created_at' => $question->topic->created_at,
                        'updated_at' => $question->topic->updated_at,
                        'deleted_at' => $question->topic->deleted_at,
                        'module_id' => $question->topic->module_id
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_a_new_question()
    {
        $data = Question::factory()->make()->toArray();

        $this->sanctumActingAsDeveloper();

        $this->assertDatabaseCount('questions', 0);

        $this->post(route('api.v1.questions.store'), $data)
            ->assertCreated();

        $this->assertDatabaseCount('questions', 1);
    }

    /** @test */
    public function it_updates_a_question()
    {
        $question = Question::factory()->create()->makeHidden('topic_id');
        $data = ['question' => 'new question?'];
        $expectation = collect($question->toArray())->merge($data)->all();

        $this->sanctumActingAsDeveloper();

        $this->patch(route(
            'api.v1.questions.update',
            ['question' => $question->id]
        ), $data)
            ->assertOk()
            ->assertJsonFragment($expectation);
    }

    /** @test */
    public function it_soft_deletes_a_question()
    {
        $question = Question::factory()->create();

        $this->sanctumActingAsDeveloper();

        $this->delete(route(
            'api.v1.questions.destroy',
            ['question' => $question->id]
        ))
            ->assertOk();

        $this->assertSoftDeleted('questions', $question->toArray());
    }
}
