<?php

use App\Models\Food;
use App\Models\Meal;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Faker\faker;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;

test('user can save a food for a meal in a date ', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'name' => 'Milanesa con pure',
        'user_id' => $user->id,
    ]);

    actingAs($user)->post('/meals', [
        'date' => $date = faker()->date(),
        'food_id' => $food->id,
        'type' => 'almuerzo',
    ])->assertSessionDoesntHaveErrors()
        ->assertSessionHas('record', 1);

    assertCount(1, $user->meals);
    $meal = $user->meals->first();
    assertTrue($meal->food->is($food));
    expect($meal->date)->toBe($date);
    expect($meal->type)->toBe('almuerzo');
});

test('user can update a meal', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'name' => 'Milanesa con pure',
        'user_id' => $user->id,
    ]);
    $meal = Meal::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)->put('/meals/' . $meal->id, [
        'food_id' => $food->id,
    ])->assertSessionHasNoErrors()->assertRedirect('/calendar');

    $meal->refresh();
    expect($meal->food->name)->toBe('Milanesa con pure');
});

test('user can not update a meal from another user', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'name' => 'Milanesa con pure',
        'user_id' => $user->id,
    ]);
    $meal = Meal::factory()->create();

    actingAs($user)->put('/meals/' . $meal->id, [
        'food_id' => $food->id,
    ])->assertForbidden();
});

test('user can not update a meal with food from another user', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create(['name' => 'Milanesa con pure']);
    $meal = Meal::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)->put('/meals/' . $meal->id, [
        'food_id' => $food->id,
    ])->assertForbidden();
});

test('user can delete a meal', function () {
    /** @var User **/
    $user = User::factory()->create();
    $meal = Meal::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)->delete('/meals/' . $meal->id, [])->assertRedirect('/calendar');

    assertCount(0, $user->meals);
});

test('user can not use a food from other user', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create(['name' => 'Milanesa con pure']);

    actingAs($user)->post('/meals', [
        'date' => faker()->date(),
        'food_id' => $food->id,
        'type' => 'almuerzo',
    ])->assertForbidden();
});

test('user can not delete a meal from another user', function () {
    /** @var User **/
    $user = User::factory()->create();
    $meal = Meal::factory()->create();

    actingAs($user)->delete('/meals/' . $meal->id, [])->assertForbidden();
});
