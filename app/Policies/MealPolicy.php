<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MealPolicy
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

    public function update(User $user, Meal $meal)
    {
        return $user->id === $meal->user->id;
    }

    public function delete(User $user, Meal $meal)
    {
        return $user->id === $meal->user->id;
    }
}
