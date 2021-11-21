<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreateFoodTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_food()
    {
        /** @var User **/
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/foods', [
                'name' => "Milanesa con pure",
            ])
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect('foods');
        ;

        $this->assertCount(1, $user->foods);
    }

    public function test_user_can_update_a_food()
    {
        /** @var User **/
        $user = User::factory()->create();
        $food = Food::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->put('/foods/' . $food->id, [
                'name' => "Milanesa con pure",
            ])
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect('foods');

        $food->refresh();
        $this->assertEquals('Milanesa con pure', $food->name);
    }
}
