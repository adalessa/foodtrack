<?php

namespace Tests\Feature;

use App\Enums\MealType;
use App\Models\Food;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSaveFoodTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_save_a_food_for_a_meal_in_a_date() {
        /** @var User **/
        $user = User::factory()->create();
        $food = Food::factory()->create([
            'name' => 'Milanesa con pure',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)->post('/meals', [
            'date' => $date = $this->faker->date(),
            'food_id' => $food->id,
            'type' => MealType::lunch()->value,
        ])->assertSessionDoesntHaveErrors()
            ->assertSessionHas('record', 1);

        $this->assertCount(1, $user->meals);
        $meal = $user->meals->first();
        $this->assertTrue($meal->food->is($food));
        $this->assertEquals($date, $meal->date);
        $this->assertInstanceOf(MealType::class, $meal->type);
        $this->assertEquals(MealType::lunch()->value, $meal->type->value);
    }

    public function test_user_can_update_a_meal() {
            /** @var User **/
            $user = User::factory()->create();
            $food = Food::factory()->create([
                'name' => 'Milanesa con pure',
                'user_id' => $user->id,
            ]);
            $meal = Meal::factory()->create([
                'user_id' => $user->id,
            ]);

            $this->actingAs($user)->put('/meals/' . $meal->id, [
                'food_id' => $food->id,
            ])->assertSessionHasNoErrors()->assertRedirect('/calendar');

            $meal->refresh();
            $this->assertEquals('Milanesa con pure', $meal->food->name);
        }

        public function test_user_can_not_update_a_meal_from_another_user() {
            /** @var User **/
            $user = User::factory()->create();
            $food = Food::factory()->create([
                'name' => 'Milanesa con pure',
                'user_id' => $user->id,
            ]);
            $meal = Meal::factory()->create();

            $this->actingAs($user)->put('/meals/' . $meal->id, [
                'food_id' => $food->id,
            ])->assertForbidden();
        }

        public function test_user_can_not_update_a_meal_with_food_from_another_user() {
            /** @var User **/
            $user = User::factory()->create();
            $food = Food::factory()->create(['name' => 'Milanesa con pure']);
            $meal = Meal::factory()->create([
                'user_id' => $user->id,
            ]);

            $this->actingAs($user)->put('/meals/' . $meal->id, [
                'food_id' => $food->id,
            ])->assertForbidden();
        }

        public function test_user_can_delete_a_meal() {
            /** @var User **/
            $user = User::factory()->create();
            $meal = Meal::factory()->create([
                'user_id' => $user->id,
            ]);

            $this->actingAs($user)->delete('/meals/' . $meal->id, [])->assertRedirect('/calendar');

            $this->assertCount(0, $user->meals);
        }

        public function test_user_can_not_use_a_food_from_other_user() {
            /** @var User **/
            $user = User::factory()->create();
            $food = Food::factory()->create(['name' => 'Milanesa con pure']);

            $this->actingAs($user)->post('/meals', [
                'date' => $this->faker->date(),
                'food_id' => $food->id,
                'type' => MealType::lunch()->value,
            ])->assertForbidden();
        }

        public function test_user_can_not_delete_a_meal_from_another_user() {
            /** @var User **/
            $user = User::factory()->create();
            $meal = Meal::factory()->create();

            $this->actingAs($user)->delete('/meals/' . $meal->id, [])->assertForbidden();
        }
}
