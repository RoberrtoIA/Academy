<?php

namespace Tests\Feature\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_list_users()
    {
        $this->sanctumActingAsManager();
        $count = User::count();

        $this->get(route('api.v1.users.index'))
            ->assertOk()
            ->assertJsonCount($count, 'data');

        $this->newUser(roles:['trainee']);

        $this->get(route('api.v1.users.index'))
            ->assertJsonCount(++$count, 'data');
    }

    /** @test */
    public function it_shows_an_user()
    {
        $me = $this->sanctumActingAsManager();

        $this->get(route('api.v1.users.show', $me->id))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $me->id,
                'email' => $me->email,
            ]);
    }

    /** @test */
    public function it_updates_an_user()
    {
        $user = $this->newUser(roles:['trainee']);
        $data = [
            'name' => 'edit user name',
            'roles' => ['developer']
        ];

        $this->sanctumActingAsManager();

        $this->patch(route('api.v1.users.update', $user->id), $data)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $data['name'],
                'roles' => [
                    ['name' => 'developer']
                ],
            ]);
    }
}
