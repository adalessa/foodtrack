<?php

use App\Models\Food;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertCount;

test('user can create a food', function () {
    /** @var User **/
    $user = User::factory()->create();

    actingAs($user)
        ->post('/foods', [
            'name' => "Milanesa con pure",
        ])
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('foods');

    assertCount(1, $user->foods);
});

test('user can update a food', function () {
    /** @var User **/
    $user = User::factory()->create();
    $food = Food::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)
        ->put('/foods/' . $food->id, [
            'name' => "Milanesa con pure",
        ])
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('foods');

    $food->refresh();
    expect($food->name)->toBe('Milanesa con pure');
});
