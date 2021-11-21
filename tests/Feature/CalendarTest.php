<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_returns_meals()
    {
        $this->withoutExceptionHandling();
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/calendar')
            ->assertViewHas('days')
        ;

        $days = $response->viewData('days');

        $this->assertCount(now()->daysInMonth, $days);
    }
}
