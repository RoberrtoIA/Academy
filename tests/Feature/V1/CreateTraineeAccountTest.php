<?php

namespace Tests\Feature\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTraineeAccountTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    /** @test */
    public function it_creates_a_new_trainee_user()
    {
        $data = User::factory()->make()->toArray();

        $this->sanctumActingAsManager();

        $this->assertDatabaseMissing('users', $data);

        $this->post(
            route('api.v1.users.createTraineeAccount'),
            $data
        )
            ->assertCreated()
            ->assertJsonFragment($data)
            ->assertJsonFragment(['roles' => [
                ['name' => 'trainee']
            ]]);

        $this->assertDatabaseHas('users', $data);
    }
}
