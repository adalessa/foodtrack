<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'food_id' => Food::factory(),
            'date' => $this->faker->date(),
            'type' => $this->faker->randomElement(['almuerzo', 'cena']),
        ];
    }
}
