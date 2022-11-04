<?php

namespace Tests\Feature\V1;

use App\Models\Program;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProgramTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

        $program->tags()->attach(Tag::factory()->create());

        $this->sanctumActingAsDeveloper();

        $this->get(route('api.v1.programs.show', ['program' => $program->id]))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'content' => $program->content,
                'tags' => [
                    ['name' => $program->tags->take(1)->first()->name]
                ],
            ]);
    }

    /** @test */
    public function it_creates_a_new_program()
    {
        $data = Program::factory()->make()->toArray();

        $data['tags'] = $this->faker->state();


        $this->sanctumActingAsDeveloper();

        $this->assertDatabaseCount('programs', 0);

        $this->post(route('api.v1.programs.store'), $data)
            ->assertCreated();
            // ->assertJsonFragment($data);

        $this->assertDatabaseCount('programs', 1);
    }

    /**
     * @test
     * @dataProvider programUpdateProvider
     */
    public function it_updates_a_program($original, $edited)
    {
        $program = Program::factory()->create();

        $program->tags()->attach(Tag::factory(['name' => $original])->create());

        $expectation = $program->toArray();
        $expectation['tags'] = $edited;

        $this->sanctumActingAsDeveloper();

        $this->patch(route(
            'api.v1.programs.update',
            ['program' => $program->id]
        ), $expectation)
            ->assertOk()
            // ->assertJsonFragment($expectation);
            ->assertJsonFragment([
                'id' => $expectation['id'],
                'title' => $expectation['title'],
                'description' => $expectation['description'],
                'content' => $expectation['content'],
                'tags' => [
                    ['name' => $edited]
                ],
            ]);
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

    /**
     * @test
     * @dataProvider crudAuthProvider
     */
    public function program_crud_has_right_authorization(
        $rol,
        $route,
        $routeParams,
        $method,
        $data,
        $expectedStatus
    ) {
        if ($routeParams['program'] ?? false) {
            Program::factory()->create(['id' => 1]);
        }

        $this->sanctumActingAs([$rol]);

        $this->$method(route("api.v1.programs.$route", $routeParams), $data)
            ->assertStatus($expectedStatus);
    }

    protected function crudAuthProvider()
    {
        return [
            'manager_index' => ['manager', 'index', [], 'get', [], 403],
            'developer_index' => ['developer', 'index', [], 'get', [], 200],
            'trainer_index' => ['trainer', 'index', [], 'get', [], 200],
            'trainee_index' => ['trainee', 'index', [], 'get', [], 200],
            'manager_show' => ['manager', 'show', ['program' => 1], 'get', [], 403],
            'developer_show' => ['developer', 'show', ['program' => 1], 'get', [], 200],
            'trainer_show' => ['trainer', 'show', ['program' => 1], 'get', [], 200],
            'trainee_show' => ['trainee', 'show', ['program' => 1], 'get', [], 200],
            'manager_store' => ['manager', 'store', [], 'post', [], 403],
            'developer_store' => ['developer', 'store', [], 'post', [], 422],
            'trainer_store' => ['trainer', 'store', [], 'post', [], 403],
            'trainee_store' => ['trainee', 'store', [], 'post', [], 403],
            'manager_update' => ['manager', 'update', ['program' => 1], 'patch', [], 403],
            'developer_update' => ['developer', 'update', ['program' => 1], 'patch', [], 200],
            'trainer_update' => ['trainer', 'update', ['program' => 1], 'patch', [], 403],
            'trainee_update' => ['trainee', 'update', ['program' => 1], 'patch', [], 403],
            'manager_destroy' => ['manager', 'destroy', ['program' => 1], 'delete', [], 403],
            'developer_destroy' => ['developer', 'destroy', ['program' => 1], 'delete', [], 200],
            'trainer_destroy' => ['trainer', 'destroy', ['program' => 1], 'delete', [], 403],
            'trainee_destroy' => ['trainee', 'destroy', ['program' => 1], 'delete', [], 403],
        ];
    }

    protected function programUpdateProvider()
    {
        return [
            ['Lorem', 'Merol'],
            ['Ipsum', 'Muspi'],
            ['Chad', 'Veni'],
            ['Marc,Loma', 'Non']
        ];
    }
}
