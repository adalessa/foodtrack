<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Food $food)
    {
        return $user->id === $food->user->id;
    }

    public function update(User $user, Food $food)
    {
        return $user->id === $food->user->id;
    }
}
