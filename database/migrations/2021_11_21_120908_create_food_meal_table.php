<?php

use App\Models\Food;
use App\Models\Meal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Meal::class);
            $table->foreignIdFor(Food::class);
            $table->timestamps();
            $table->unique(['meal_id', 'food_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_meal');
    }
}
