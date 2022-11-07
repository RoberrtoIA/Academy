<?php

namespace Tests\Feature\V1;

use App\Models\Homework;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeworkTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_list_homeworks()
    {
        // $homeworks = Homework::factory(3)->create()->makeHidden('module_id')->toArray();

        // $this->sanctumActingAsDeveloper();

        // $this->get(route('api.v1.homeworks.index'))
        //     ->assertOk()
        //     ->assertJsonFragment(['data' => $homeworks]);

        $count = 5;
        Homework::factory()->count($count)->create();

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.homeworks.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }

    /** @test */
    public function it_shows_a_homework()
    {
        $homework = Homework::factory()->create()->load('module');

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.homeworks.show', ['homework' => $homework->id]))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $homework->id,
                    'doc' => $homework->doc,
                    'created_at' => $homework->created_at,
                    'updated_at' => $homework->updated_at,
                    'module' => [
                        'id' => $homework->module->id,
                        'title' => $homework->module->title,
                        'description' => $homework->module->description,
                        'content' => $homework->module->content,
                        'created_at' => $homework->module->created_at,
                        'updated_at' => $homework->module->updated_at,
                        'deleted_at' => $homework->module->deleted_at,
                        'program_id' => $homework->module->program_id
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_a_new_homework()
    {
        $data = Homework::factory()->make()->toArray();

        $this->sanctumActingAsDeveloper();

        $this->assertDatabaseCount('homeworks', 0);

        $this->post(route('api.v1.homeworks.store'), $data)
            ->assertCreated();

        $this->assertDatabaseCount('homeworks', 1);
    }

    /** @test */
    public function it_updates_a_homework()
    {
        $homework = Homework::factory()->create()->makeHidden('module_id');
        $data = ['doc' => 'new doc'];
        $expectation = collect($homework->toArray())->merge($data)->all();

        $this->sanctumActingAsDeveloper();

        $this->patch(route(
            'api.v1.homeworks.update',
            ['homework' => $homework->id]
        ), $data)
            ->assertOk()
            ->assertJsonFragment($expectation);
    }

    /** @test */
    public function it_soft_deletes_a_homework()
    {
        $homework = Homework::factory()->create();

        $this->sanctumActingAsDeveloper();

        $this->delete(route(
            'api.v1.homeworks.destroy',
            ['homework' => $homework->id]
        ))
            ->assertOk();

        $this->assertSoftDeleted('homeworks', $homework->toArray());
    }
}
