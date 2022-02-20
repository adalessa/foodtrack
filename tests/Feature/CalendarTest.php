<?php

use App\Models\Meal;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\withoutExceptionHandling;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

it('returns_the_meals_for_the_current_month', function () {
    /** @var User */
    $user = User::factory()
        ->withPersonalTeam()
        ->has(Meal::factory()->count(15))
        ->create()
    ;

    withoutExceptionHandling();
    $response = actingAs($user)
        ->get('/calendar')
        ->assertViewHas('calendar')
    ;

    $calendar = $response->viewData('calendar');

    assertCount(now()->daysInMonth, $calendar->days());
    assertEquals($user->meals->count(), $calendar->meals()->flatten()->count());
});
