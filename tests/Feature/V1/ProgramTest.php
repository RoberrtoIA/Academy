<?php

namespace Tests\Feature\V1;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_list_programs()
    {
        $count = 5;
        Program::factory()->count($count)->create();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.programs.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_a_program()
    {
        $program = Program::factory()->create();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.programs.show', ['program' => $program->id]))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'content' => $program->content,
            ]);
    }

    /** @test */
    public function it_creates_a_new_program()
    {
        $data = Program::factory()->make()->toArray();

        $this->sanctumActingAsDeveloper();

        $this->assertDatabaseCount('programs', 0);

        $this->post(route('api.v1.programs.store'), $data)
            ->assertCreated()
            ->assertJsonFragment($data);

        $this->assertDatabaseCount('programs', 1);
    }

    /** @test */
    public function it_updates_a_program()
    {
        $program = Program::factory()->create();
        $data = ['title' => 'changed'];
        $expectation = collect($program->toArray())->merge($data)->all();

        $this->sanctumActingAsDeveloper();

        $this->patch(route(
            'api.v1.programs.update',
            ['program' => $program->id]
        ), $data)
            ->assertOk()
            ->assertJsonFragment($expectation);
    }

    /** @test */
    public function it_soft_deletes_a_program()
    {
        $program = Program::factory()->create();

        $this->sanctumActingAsDeveloper();

        $this->delete(route(
            'api.v1.programs.destroy',
            ['program' => $program->id]
        ))
            ->assertOk();

        $this->assertSoftDeleted('programs', $program->toArray());
    }
}
