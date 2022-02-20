<?php

use App\Enums\MealType;
use App\Models\Food;
use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\withoutExceptionHandling;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;

test('user can save a food for a meal in a date ', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'name' => 'Milanesa con pure',
        'user_id' => $user->id,
    ]);

    withoutExceptionHandling();
    actingAs($user)->post('/meals', [
        'date' => $date = now(),
        'foods' => [$food->id],
        'type' => MealType::Lunch->value,
    ])->assertSessionDoesntHaveErrors()
        ->assertSessionHas('record', 1);

    assertCount(1, $user->meals);
    $meal = $user->meals->first();
    expect($meal->foods->count())->toBe(1);
    assertTrue($meal->foods->first()->is($food));
    expect($meal->date)->toBeInstanceOf(Carbon::class);
    expect($meal->date->isSameAs($date))->toBeTrue();
    expect($meal->type)->toBeInstanceOf(MealType::class);
    expect($meal->type->value)->toBe(MealType::Lunch->value);
});

test('user can update a meal', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'name' => 'Milanesa con pure',
        'user_id' => $user->id,
    ]);
    $meal = Meal::factory()
        ->has(Food::factory()->count(2), 'foods')
        ->create([
            'user_id' => $user->id,
        ])
    ;

    actingAs($user)->put('/meals/' . $meal->id, [
        'foods' => [$food->id],
    ])->assertSessionHasNoErrors()->assertRedirect('/calendar');

    $meal->refresh();
    expect($meal->foods->first()->name)->toBe('Milanesa con pure');
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
        'foods' => [$food->id],
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

test('user can not delete a meal from another user', function () {
    /** @var User **/
    $user = User::factory()->create();
    $meal = Meal::factory()->create();

    actingAs($user)->delete('/meals/' . $meal->id, [])->assertForbidden();
});
