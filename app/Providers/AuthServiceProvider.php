<?php

namespace App\Providers;

use App\Models\Food;
use App\Models\Meal;
use App\Models\Team;
use App\Policies\FoodPolicy;
use App\Policies\MealPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Food::class => FoodPolicy::class,
        Meal::class => MealPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
